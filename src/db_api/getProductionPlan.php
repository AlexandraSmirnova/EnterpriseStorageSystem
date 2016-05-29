<?php
function getProductionPlan($db, $month, $year){
    $sql = "SELECT id_model, sum(count) count, start_production FROM production_plan WHERE MONTH(start_production) = {?} AND YEAR(start_production) = {?} GROUP BY id_model, start_production";
    $models = $db->select($sql, array($month, $year));
    return $models;
}

function getPlanByDay($db, $date) {
    global $db;
    $sql = "SELECT id_model, name, count, start_production
            FROM production_plan
            JOIN model
            WHERE id_model = Id_M 
            AND TO_DAYS(start_production) -  TO_DAYS({?}) = 0
            LIMIT 0 , 30";
    $result = $db->select($sql, array($date));
    return $result;
}

function getPlanCurrentMonth($db) {
    $sql = "SELECT id_model, name, sum(count) count, start_production
            FROM production_plan
            JOIN model
            WHERE id_model = Id_M
            AND MONTH(start_production) = MONTH(CURRENT_DATE) AND start_production > CURRENT_DATE 
            GROUP BY id_model, start_production" ;
    return $db->select($sql);
}
?>


