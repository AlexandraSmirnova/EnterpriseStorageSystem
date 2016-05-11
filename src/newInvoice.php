<?php
//TODO: добавить в списание зависимость от количества
	require('db_api/dataBase.php');
	$db = DataBase::getDB();
	
	if(isset($_GET['Info'])){
		// если отправили уже из формы данные, то сохраняем новую закупку
		include '../includes/inition.php';
		try{
			$query = "INSERT INTO invoice 
						SET component={?}, supplier={?}, count={?}, item_cost={?}, total_cost=0, order_date=CURRENT_DATE, plan_date={?}";
			$id_i =  $db->query($query, array($_POST['id_d'], $_POST['id_s'], $_POST['count'], $_POST['cost'], $_POST['date']));
						
			include '../includes/procedures/totalCost.php';
		}
		catch (ErrorException $e){
			$output = 'Ошибка при добавлении закупки в базу данных';
			include '../includes/output.html.php';
			exit(1);
		}
		
		$sql = "SELECT Name FROM component WHERE Id_C = {?} " ;
		$detail = $db->selectCell($sql, array($id_d));
		
		$sql = "SELECT name FROM supplier WHERE id = {?}" ;
		$supplier = $db->selectCell($sql, array($id_s));
				
		$pagetitle = "Поставка";
		$tpl = "../templates/invoice/tpl_reportInvoice.php";
		include("../templates/tpl_main.php");

		exit();	
	}
	
	if(isset($_GET['Delete'])){
		// если отменили поставку - удаляем запись.
		$id_i = $_POST['id_i'];
		$sql = "DELETE FROM invoice WHERE id_I ={?}";
		$result = $db->query($sql, array($id_i));
	}
	
	if(isset($_GET['Success'])){
		$pagetitle = "Поставка оформлена";
		$tpl = "../templates/invoice/tpl_successInvoice.php";
		include("../templates/tpl_main.php");	
		exit();
	}
	
	$sql = "SELECT Id_C, Name FROM component WHERE is_atom = 1" ;
	$details = $db->select($sql);
	
	$sql = "SELECT id, name FROM supplier" ;
	$suppliers = $db->select($sql);
	
	$pagetitle = "Закупка";
	$tpl = "../templates/invoice/tpl_newInvoice.php";
	include("../templates/tpl_main.php");	
?>