<?php 

if(isset($_GET['id'])){
	$id = $_GET['id'];	
	$detail = $_GET['name'];
	include 'entitiesOfDetail.php';
	exit();
}

require('db_api/dataBase.php');
$db = DataBase::getDB();

$sql = "SELECT Id_C, Name, Cost from component WHERE is_atom = 1" ;
$details = $db->select($sql);

$pagetitle = "Детали";
$tpl = "../templates/detail/tpl_detailList.php";
include("../templates/tpl_main.php");
?>