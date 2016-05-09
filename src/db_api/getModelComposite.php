<?php
function getModelComposite($db, $model_id){
    $sql = "SELECT name, entities from tmp_detail_info WHERE parent_id = (SELECT tree_place FROM model WHERE Id_M = {?})";
    $details = $db->select($sql, array($model_id));
    return $details;
}
?>