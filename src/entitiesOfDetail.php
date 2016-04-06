<?php	
include( "../includes/dbconnect.php" ); 
include( "../includes/execute_select.php" );

$sql = "SELECT id, name, parent, entities from tmp_detail_info WHERE name = '".$detail."'" ;
$result = execute_select($pdo, $sql);
		
if(($result -> rowCount()) != 0){
	while ( $row = $result->fetch() ) {
		$details[]=array('id'=>$row['id'], 'name'=>$row['name'], 'parent'=>$row['parent'], 'entities'=>$row['entities']);
	}
}	
else{	
	$output = "Деталь не используется ни в одной из моделей";	
}	
$pdo = null;

$pagetitle = "Детали";
$tpl = "../templates/detail/tpl_detailEntities.php";
include("../templates/tpl_main.php");

?>