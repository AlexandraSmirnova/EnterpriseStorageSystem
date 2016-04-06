<?php 
include '../includes/dbconnect.php';
include '../includes/execute_select.php';
require('classes/dataBase.php');
$db = DataBase::getDB();

if(isset($_GET['id'])){
	$id = $_GET['id'];	
	$model = $_GET['name'];
	include 'compositeOfModel.php';
	//$pdo = null;
	
	$pagetitle = "Модели";
	$tpl = "../templates/model/tpl_modelContents.php";
	include("../templates/tpl_main.php");
	exit();
}

$sql = "SELECT Id_C, Name, Cost from Component WHERE Id_C IN (SELECT child FROM structure WHERE parent = 0)" ;
$result = execute_select($pdo, $sql);
		
while ( $row = $result->fetch() ) {
	$models[]=array('id'=>$row['Id_C'], 'name'=>$row['Name'], 'price'=>$row['Cost']);
}
	
$pdo = null;

$pagetitle = "Модели";
$tpl = "../templates/model/tpl_modelList.php";
include '../templates/tpl_main.php';
?>