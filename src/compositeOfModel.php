<?php 
$sql="SELECT  Name, Entities from tmp_detail_info WHERE parent_id = (SELECT tree_place FROM Model WHERE component_id = $id)" ;
$details = $db->select($sql);

//if(($details -> rowCount()) != 0) {
//	while ($row = $result->fetch()) {
//		$details[] = array('name' => $row['Name'], 'count' => $row['Entities']);
//	}
//}

foreach($details as  $value){
	echo $value['Name'];
}

if(empty($details)){
	$output = "В модели еще не используется ни одной детали";
}
?>