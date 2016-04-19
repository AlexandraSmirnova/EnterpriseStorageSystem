<?php
function getDetailProductionPlan($db, $month, $year, $models=array()){
    // TODO: ADD " id_models in $models"
    $sql = "SELECT id_model, count FROM production_plan WHERE MONTH(start_production) = {?} AND YEAR(start_production) = {?}";
    $models = $db-> select($sql, array($month, $year));
    return $models;
}
?>