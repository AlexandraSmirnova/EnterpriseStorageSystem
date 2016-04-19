<?php
function getEntitiesOfDetail($db, $detail_name){
    $sql = "SELECT id, name, parent, entities from tmp_detail_info WHERE name = {?}" ;
    $systems = $db->select($sql, array($detail_name));
    return $systems;
}
?>