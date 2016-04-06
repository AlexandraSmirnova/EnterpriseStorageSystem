<?php
	include '../includes/dbconnect.php';
	include '../includes/execute_select.php';
	
	function inventoryByDay($date){
		global $pdo;
		$sql = "SELECT name_c, count, time FROM tmp_storage_inventory WHERE TO_DAYS(time) -  TO_DAYS('$date') = 0";
		$result = execute_select($pdo, $sql);
		return $result;
	}
	
	if(isset($_GET['Inventory'])){
		include '../includes/procedures/storageToday.php';
	}
		
	if(isset($_GET['Info'])){
		$date = $_POST['date'];		
		$result = inventoryByDay($date);
		
		if(($result -> rowCount()) == 0){
			include '../includes/procedures/getInventoryByDay.php';
			$result = inventoryByDay($date);
		}
		
		while ( $row = $result->fetch() ) {
			$details[]=array('name'=>$row['name_c'], 'count'=>$row['count'], 'time' => $row['time']);			
		}
		
		$pagetitle = "Склад";
		$tpl = "../templates/storage/tpl_storage.php";
		include("../templates/tpl_main.php");		
		$pdo = null;
		exit();		
	}
	
	$sql = "SELECT name_c, count, time FROM tmp_storage_inventory WHERE time = (SELECT max(time) FROM tmp_storage_inventory)";
	$result = execute_select($pdo, $sql);
		
	while ( $row = $result->fetch() ) {
		$details[]=array('name'=>$row['name_c'], 'count'=>$row['count'], 'time' => $row['time']);
	}		
	
	$pdo = null;
			
	$pagetitle = "Склад";
	$tpl = "../templates/storage/tpl_storage.php";
	include("../templates/tpl_main.php");		
?>