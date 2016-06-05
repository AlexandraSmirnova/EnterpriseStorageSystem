<?php
require('db_api/dataBase.php');
$db = DataBase::getDB();
include 'db_api/getDetailInfo.php';
include 'db_api/getProductionPlan.php';
include 'db_api/getSupplierName.php';
include 'db_api/getModelInfo.php';

if(isset($_GET['Info'])) {
    $date = $_POST['date'];
    $models = getPlanByDay($db, $date);

    if (count($models) != 0) {
        $pagetitle = "План производства";
        $tpl = "../templates/production/tpl_productionPlan.php";
        include("../templates/tpl_main.php");
        exit();
    }
    else {
        $error_str = "На указанную вами дату не планируется ни одной сборки.<br>Выберите другую дaту";
    }
}

$models = getPlanCurrentMonth($db);

if(isset($_GET['orders'])) {
    // получаем список деталей исходя из плана
    include '../includes/detailsFromPlan.php';

    $new_datails = array();
    foreach ($details as $detail) {
        // TODO: переделать чтобы не приходилось доставать id
        $sql = "SELECT id_c FROM component WHERE name = {?}";
        $id_c = $db->selectCell($sql, array($detail['name']));
        $default_period = 5;
        $supplier_id = 1;
        // выбираем поставщика с минимальным временем исполнения заказа
        $sql = "SELECT supplier, MIN( days ) days FROM (
        
            SELECT component, supplier, AVG( TO_DAYS( completion_date ) - TO_DAYS( order_date ) ) days
            FROM  invoice
            WHERE component ={?}
            AND YEAR( CURRENT_DATE ) = YEAR( order_date )
            GROUP BY supplier
            UNION
            SELECT component, supplier, AVG( TO_DAYS( completion_date ) - TO_DAYS( order_date ) ) days
            FROM invoice
            WHERE component ={?}
            AND YEAR( CURRENT_DATE ) - YEAR( order_date ) =1
            AND MONTH( order_date ) > MONTH( CURRENT_DATE )
            GROUP BY supplier
            )S";
        $result = $db->selectRow($sql, array($id_c, $id_c));
        if ($result) {
            $supplier_id = $result['supplier'];
            $sql = "SELECT TO_DAYS( completion_date ) - TO_DAYS( order_date ) days
                FROM  invoice
                WHERE component = {?}
                AND supplier = {?}
                AND YEAR( CURRENT_DATE ) = YEAR( order_date ) 
                GROUP BY supplier
                UNION 
                SELECT TO_DAYS( completion_date ) - TO_DAYS( order_date ) days
                FROM invoice
                WHERE component = {?}
                AND supplier = {?}
                AND YEAR( CURRENT_DATE ) - YEAR( order_date ) =1
                AND MONTH( order_date ) > MONTH( CURRENT_DATE ) 
                GROUP BY supplier";
            $days = $db->select($sql, array($id_c, $result['supplier'], $id_c, $result['supplier']));
            $order_days = 0;
            if (count($days) > 1) {
                foreach ($days as $day) {
                    $order_days += $day['days'];
                }
                $order_days /= count($days) + 1;
            } else if (count($days) == 0) {
                $order_days =  $default_period;
            } else {
                $order_days = $days[0]['days'] + 1;
            }
        }
        else {
            $order_days =  $default_period;
        }
        if(!$supplier_id) {
            $supplier_id = getPotentialSupplierId($db, $id_c);
        }
        $supplier = getSupplierName($db, $supplier_id);
        $date_order = new DateTime($detail['date_required']);
        $date_order->modify('-'.$order_days.' day');
        $current_count = getDetailInStorage($db, $detail['name']);
        $reserve_count = getDetailReserveStock($db, $id_c, date('m'), date('Y'));
        if(empty($current_count)){
            $current_count = 0;
        }

        $plan_count =  $detail['required'] + $reserve_count - $current_count;
        if($plan_count > 0) {
            $new_details[] = array_merge($detail, array('supplier' => $supplier, 'count' => $plan_count, 'date_order' => $date_order->format('d.m.Y')));
        }
    }

    // сортировка результата по дате
    $by = 'date_order';
    usort($new_details, function($first, $second) use( $by  ) {
        if ($first[$by]>$second[$by]) { return 1; }
        elseif ($first[$by]<$second[$by]) { return -1; }
        return 0;
    });

    $pagetitle = "План закупок";
    $tpl = "../templates/production/tpl_orderPlan.php";
    include("../templates/tpl_main.php");
    exit();
}

$all_models=getModelList($db);

$pagetitle = "План производства";
$tpl = "../templates/production/tpl_productionPlan.php";
include("../templates/tpl_main.php");
?>