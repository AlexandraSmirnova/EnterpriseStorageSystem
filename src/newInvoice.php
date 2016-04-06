<?php
	include '../includes/dbconnect.php';
	include '../includes/execute_select.php';
	
	if(isset($_GET['Info'])){
		// если отправили уже из формы данные, то сохраняем новую закупку
		include '../includes/inition.php';		
		//if($id_s == 0  || id_d == 0){
		//	exit();
		//}
		try{
			$sql= "INSERT INTO invoice 
						SET component=:id_d, supplier=:id_s, count=:count, item_cost=:cost, total_cost=0, date=:date";
			$s=$pdo->prepare($sql);
			$s->bindValue(':id_d', $_POST['id_d']);
			$s->bindValue(':id_s', $_POST['id_s']);			
			$s->bindValue(':count',  $_POST['count']);			
			$s->bindValue(':cost', $_POST['cost']);		
			$s->bindValue(':date', $_POST['date']);
			$s->execute();
			$id_i = $pdo->lastInsertId();
						
			include '../includes/procedures/totalCost.php';
		}
		catch (PDOexception $e){
			$output = 'Ошибка при добавлении закупки в базу данных';
			include '../includes/output.html.php';
			exit(1);
		}
		
		$sql = "SELECT Name FROM component WHERE Id_C = ".$id_d ;
		$result = execute_select($pdo, $sql);
		$detail = $result->fetch();
		
		$sql = "SELECT name FROM supplier WHERE id = ".$id_s ;
		$result = execute_select($pdo, $sql);
		$supplier = $result->fetch(); 
				
		$pagetitle = "Поставка";
		$tpl = "../templates/invoice/tpl_reportInvoice.php";
		include("../templates/tpl_main.php");
		
		$pdo = null;
		exit();	
	}
	
	if(isset($_GET['Delete'])){
		$id_i = $_POST['id_i'];
		$sql = "DELETE FROM invoice WHERE id_I = $id_i";
		$result = execute_select($pdo, $sql);		
	}
	
	if(isset($_GET['Success'])){
		$pagetitle = "Поставка оформлена";
		$tpl = "../templates/invoice/tpl_successInvoice.php";
		include("../templates/tpl_main.php");	
		exit();
	}
	
	$sql = "SELECT Id_C, Name FROM Component WHERE is_atom = 1" ;
	$result = execute_select($pdo, $sql);
		
	while ( $row = $result->fetch() ) {
		$details[]=array('id'=>$row['Id_C'], 'name'=>$row['Name']);
	}
	
	$sql = "SELECT id, name FROM supplier" ;
	$result = execute_select($pdo, $sql);
		
	while ( $row = $result->fetch() ) {
		$suppliers[]=array('id'=>$row['id'], 'name'=>$row['name']);
	}
	
	$pdo = null;
	$pagetitle = "Закупка";
	$tpl = "../templates/invoice/tpl_newInvoice.php";
	include("../templates/tpl_main.php");	
?>