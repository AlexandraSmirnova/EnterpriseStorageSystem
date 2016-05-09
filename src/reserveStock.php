<?php
require('db_api/dataBase.php');
$db = DataBase::getDB();
include 'calculations/standartDeviation.php';
include 'db_api/getModelComposite.php';
include 'db_api/getProductionPlan.php';

if(isset($_GET['Info'])){
    require('calculations/laplasTable.php');
    $laplas = LaplasTable::getTable();
    
    $t_param = $_POST['t_param'];
    $date = $_POST['date'];

    if (empty($date)) {
        $output = "Вы не указали  месяц и год производства";
        exit();
    }
    if (empty($t_param)) {
        echo "Не передали параметр";
    }
    
    $period_month = explode('-', $date);
    #echo $period_month[0]." ";
    #echo $period_month[1]." ";

    $models = getProductionPlan($db, $period_month[1], $period_month[0]);

    $details = array();

    foreach( $models as $model) {
        $id = $model['id_model'];
        $plan_count = $model['count'];
        echo $plan_count;

        $details_of_model = getModelComposite($db, $id);
        foreach ($details_of_model as $item ) {
            $needle = $item["name"];
            // поиск записи о детали в $details
            $result = array_filter($details, function($innerArray){
                global $needle;
                //return in_array($needle, $innerArray);    //Поиск по всему массиву
                return ($innerArray['name'] == $needle); //Поиск по первому значению
            });


            $indexes = array_keys($result);
            $index = $indexes[0];

            if (isset($index)) {
                $details[$index]['entities'] += $item['entities'];
                $details[$index]['required'] += $item['entities'] * $plan_count;
            }
            else {
                $details[] = array_merge( $item, array('required' => $item['entities'] * $plan_count));
            }
        }
    }

    foreach ($details as $key => $value){
        echo "<br>".$key." : ".$value['name']." - ".$value['required']."<br>";
    }

    for ($i = 0; $i < count($details); $i++) {
        $difference = array();

        $sql = "SELECT Id_C FROM component WHERE name={?}";
        $id_C = $db->selectCell($sql, array($details[$i]['name']));

        $sql = "SELECT overal_difference FROM reserve_stock WHERE YEAR(CURRENT_DATE) = year and id_component={?} UNION SELECT overal_difference FROM reserve_stock WHERE YEAR(CURRENT_DATE) - year = 1 and month > MONTH(CURRENT_DATE) AND id_component={?}";
        $result = $db->select($sql, array($id_C, $id_C));

        foreach ($result as $row) {
            $difference[] = $row['overal_difference'];
        }

        $sigma = standartDeviation($difference);

        $details[$i] = array_merge($details[$i], array(
            "reserve" => ceil($sigma * $laplas->getParameter($t_param))
        ));

        //$required_details = $plan_count * $details[$i]['entities'];
        //echo $details[$i]['entities'];
        //$sql = "INSERT INTO reserve_stock SET id_component = {?}, month = MONTH(CURRENT_DATE), year = YEAR(CURRENT_DATE), demand_forecast = {?}, reserve_stock = {?}";
        //$last_id = $db->query($sql, array($id_C, $required_details , $details[$i]['reserve']));
    }

    $pagetitle = "Страховой запас";
    $tpl = "../templates/invoice/tpl_reserveStockTable.php";
    include '../templates/tpl_main.php';
    exit();
}

$sql = "SELECT Id_M, Name FROM model";
$models = $db->select($sql);

$pagetitle = "Страховой запас";
$tpl = "../templates/invoice/tpl_reserveForm.php";
include("../templates/tpl_main.php");
?>

