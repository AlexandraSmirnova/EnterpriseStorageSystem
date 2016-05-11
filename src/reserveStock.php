<?php
require('db_api/dataBase.php');
$db = DataBase::getDB();
include 'calculations/standartDeviation.php';
include 'db_api/getModelComposite.php';
include 'db_api/getDetailInfo.php';

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
        $t_param = 0.95;
    }
    
    $period_month = explode('-', $date);
    #echo $period_month[0]." ";
    #echo $period_month[1]." ";

    $models = getProductionPlan($db, $period_month[1], $period_month[0]);

    include 'includes/detailsFromPlan.php';
    
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

        $sql = "SELECT id_component FROM reserve_stock WHERE id_component = {?} AND month = {?} AND year = {?} ";
        $result = $db->selectCell($sql, array($id_C, $period_month[1], $period_month[0]));
        if(empty($result)) {
            $sql = "INSERT INTO reserve_stock (id_component, month, year, demand_forecast, reserve_stock) VALUES({?}, {?}, {?}, {?}, {?})";
            $last_id = $db->query($sql, array($id_C, $period_month[1], $period_month[0], $details[$i]['required'], $details[$i]['reserve']));
        }
        else {
            $sql = "UPDATE reserve_stock SET  demand_forecast = {?}, reserve_stock = {?} WHERE id_component = {?}";
            $last_id = $db->query($sql, array($details[$i]['required'], $details[$i]['reserve'], $id_C));
        }
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

