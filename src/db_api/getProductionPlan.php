<?php
function getProductionPlan($db, $month, $year){
    $sql = "SELECT id_model, sum(count) count FROM production_plan WHERE MONTH(start_production) = {?} AND YEAR(start_production) = {?} GROUP BY id_model";
    $models = $db->select($sql, array($month, $year));
    return $models;
}
?>