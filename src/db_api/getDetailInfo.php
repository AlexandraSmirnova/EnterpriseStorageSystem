<?php
function getEntitiesOfDetail($db, $detail_name) {
    $sql = "SELECT id, name, parent, entities from tmp_detail_info WHERE name = {?}" ;
    $systems = $db->select($sql, array($detail_name));
    return $systems;
}

function getDetailProductionPlan($db, $month, $year, $models=array()) {
    // TODO: ADD " id_models in $models"
    $sql = "SELECT id_model, count FROM production_plan WHERE MONTH(start_production) = {?} AND YEAR(start_production) = {?}";
    $models = $db-> select($sql, array($month, $year));
    return $models;
}

function getDetailInStorage($db, $detail_name) {
    $sql = "SELECT count FROM tmp_storage_inventory WHERE time = (SELECT max(time) FROM tmp_storage_inventory) and name_c = {?}";
    return $db->selectCell($sql, array($detail_name));
}

function getDetailReserveStock($db, $detail_id, $month, $year) {
    $sql = "SELECT reserve_stock FROM reserve_stock WHERE id_component = {?} AND month={?} AND year={?}";
    return $db->selectCell($sql, array($detail_id, $month, $year));
}

function getPotentialSupplierId($db, $detail_id) {
    $sql = "SELECT id_s FROM component_supplier WHERE id_c = {?} AND priority IN (            
                SELECT MAX( priority ) FROM (                
                  SELECT priority FROM component_supplier WHERE id_c = {?} )A ) LIMIT 0, 1";
    return $db->selectCell($sql, array($detail_id, $detail_id));
}
?>