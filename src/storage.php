<?php
	require('classes/dataBase.php');
	$db = DataBase::getDB();
	
	function inventoryByDay($date){
		global $db;
		$sql = "SELECT name_c, count, time FROM tmp_storage_inventory WHERE TO_DAYS(time) -  TO_DAYS({?}) = 0";
		$result = $db->select($sql, array($date));
		return $result;
	}
	
	if(isset($_GET['Inventory'])){
		include '../includes/procedures/storageToday.php';
	}
		
	if(isset($_GET['Info'])){
		$date = $_POST['date'];		
		$details = inventoryByDay($date);
		
		if(count($details) == 0){
			include '../includes/procedures/getInventoryByDay.php';
			$details = inventoryByDay($date);
		}
		
		$pagetitle = "Склад";
		$tpl = "../templates/storage/tpl_storage.php";
		include("../templates/tpl_main.php");
		exit();		
	}
	
	$sql = "SELECT name_c, count, time FROM tmp_storage_inventory WHERE time = (SELECT max(time) FROM tmp_storage_inventory)";
	$details = $db->select($sql);

	$pagetitle = "Склад";
	$tpl = "../templates/storage/tpl_storage.php";
	include("../templates/tpl_main.php");		
?>