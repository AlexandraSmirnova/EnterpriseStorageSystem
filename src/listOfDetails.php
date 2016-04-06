<?php 

if(isset($_GET['id'])){
	$id = $_GET['id'];	
	$detail = $_GET['name'];
	include 'entitiesOfDetail.php';
	exit();
}
	
include( "../includes/dbconnect.php" ); 
include( "../includes/execute_select.php" );

$sql = "SELECT Id_C, Name, Cost from Component WHERE is_atom = 1" ;
$result = execute_select($pdo, $sql);
		
while ( $row = $result->fetch() ) {
	$details[]=array('id'=>$row['Id_C'], 'name'=>$row['Name'], 'price'=>$row['Cost']);
}
	
$pdo = null;

$pagetitle = "Детали";
$tpl = "../templates/detail/tpl_detailList.php";
include("../templates/tpl_main.php");
?>