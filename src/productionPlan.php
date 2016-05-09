<?php
require('db_api/dataBase.php');
$db = DataBase::getDB();

function seePlanByDay($date) {
    global $db;
    $sql = "SELECT id_model, name, count, start_production date
            FROM production_plan
            JOIN model
            WHERE id_model = Id_M 
            AND TO_DAYS(start_production) -  TO_DAYS({?}) = 0
            LIMIT 0 , 30";
    $result = $db->select($sql, array($date));
    return $result;
}

if(isset($_GET['Info'])) {
    $date = $_POST['date'];
    $models = seePlanByDay($date);

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
$sql = "SELECT id_model, name, count, start_production date
            FROM production_plan
            JOIN model
            WHERE id_model = Id_M 
            AND start_production >= CURRENT_DATE 
            LIMIT 0 , 30" ;
$models = $db->select($sql);

$pagetitle = "План производства";
$tpl = "../templates/production/tpl_productionPlan.php";
include("../templates/tpl_main.php");
?>