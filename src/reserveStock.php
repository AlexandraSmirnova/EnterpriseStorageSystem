<?php
require('classes/dataBase.php');
$db = DataBase::getDB();
include 'calculations/standartDeviation.php';

if(isset($_GET['Info'])){
    $id = $_POST['id_m'];
    $t_param = $_POST['t_param'];

    if (empty($id)) {
        $output = "Вы не указали модель";
        exit();
    }
    if (empty($t_param)) {
        echo "Не передали параметр";
    }
    
    include 'compositeOfModel.php';
    require('calculations/laplasTable.php');
    $laplas = LaplasTable::getTable();
    $sql = "SELECT sum(count) from production_plan Where id_model = {?}";
    $plan_count = $db->selectCell($sql, array($id));

    for($i = 0; $i < count($details) ; $i++ ) {
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
            "reserve" => $plan_count * ceil($sigma * $laplas->getParameter($t_param))
        ));
    }

    $pagetitle = "Страховой запас";
    $tpl = "../templates/invoice/tpl_reserveStockTable.php";
    include '../templates/tpl_main.php';
    exit();
}

$sql = "SELECT Id_M, Name FROM Model";
$models = $db->select($sql);

$pagetitle = "Страховой запас";
$tpl = "../templates/invoice/tpl_reserveForm.php";
include("../templates/tpl_main.php");
?>

