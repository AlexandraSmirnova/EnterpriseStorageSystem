<?php
require('db_api/dataBase.php');
$db = DataBase::getDB();

if(isset($_GET['id'])){
	$id = $_GET['id'];	
	$model = $_GET['name'];
	
	include 'db_api/getModelComposite.php';
	$details = getModelComposite($db, $id);
	
	if(empty($details)){
		$output = "В модели еще не используется ни одной детали";
	}

	$pagetitle = "Модели";
	$tpl = "../templates/model/tpl_modelContents.php";
	include("../templates/tpl_main.php");
	exit();
}

//$sql = "SELECT Id_C, Name, Cost from Component WHERE Id_C IN (SELECT child FROM structure WHERE parent = 0)" ;
$sql = "SELECT Id_M, m.Name, Cost FROM Model m JOIN Component c WHERE Id_C = component_id;";
$models = $db->select($sql);

$pagetitle = "Модели";
$tpl = "../templates/model/tpl_modelList.php";
include '../templates/tpl_main.php';
?>