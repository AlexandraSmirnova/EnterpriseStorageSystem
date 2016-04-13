<?php 
$sql="SELECT name, entities from tmp_detail_info WHERE parent_id = (SELECT tree_place FROM Model WHERE Id_M = {?})" ;
$details = $db->select($sql, array($id));

if(empty($details)){
	$output = "В модели еще не используется ни одной детали";
}
?>