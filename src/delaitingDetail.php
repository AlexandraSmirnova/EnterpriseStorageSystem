<?php
session_start();
require('db_api/dataBase.php');
$db = DataBase::getDB();

if(isset($_GET['Info'])){
	$_SESSION['model'] =  $_POST['id'];	
	$sql = "SELECT Name FROM component WHERE Id_C = {?}";
	$_SESSION['model_name'] = $db->selectCell($sql, array($_SESSION['model']));
}

// если массив под названием item _id не инициализирован, то инициализаруем его
if(!isset($_SESSION['name'])){
	$_SESSION['name'] = array();
	$_SESSION['count'] = array();
} 
  
if(isset($_GET['Detail'])){	
	$_SESSION['name'][]= $_POST['name'];
	$_SESSION['count'][]= $_POST['count'];	
}

if(isset($_GET['Show'])){			
	for ($i = 0; $i < count($_SESSION['name']); $i++){			
		$names[] = $_SESSION['name'][$i];
		$count[] = $_SESSION['count'][$i];
	}
	if($i > 0){
		$pagetitle = "Выбранные детали";
		$tpl = "../templates/assembly/tpl_showChoice.php";
		include '../templates/tpl_main.php';
		exit();
	}
	else{
		$output = "Вы не выбрали ни одной детали";
	}
}

if(isset($_GET['Del'])){
	// Очищение выбора	
	unset ($_SESSION['name']);
	unset ($_SESSION['count']);
	unset ($_SESSION['model']);
	unset ($_SESSION['model_name']);
}

if(isset($_GET['Ok'])){	
	for ($i = 0; $i < count($_SESSION['name']); $i++){		
		try{
            $sql = "SELECT Id_C FROM component Where name={?}";
            $id_detail = $db->selectCell($sql, array($_SESSION['name'][$i]));

            $sql = "INSERT INTO expenditure 
						SET component ={?}, count={?},  date=NOW()";
            $last_id = $db->query($sql, array($id_detail, $_SESSION['count'][$i]));

			for ($i = 0; $i < count($_SESSION['name']); $i++){		
				$names[] = $_SESSION['name'][$i];
				$count[] = $_SESSION['count'][$i];
			}
			unset ($_SESSION['name']);
			unset ($_SESSION['count']);
			unset ($_SESSION['model']);
			unset ($_SESSION['model_name']);
			$pagetitle = "Выбранные детали";
			$tpl = "../templates/assembly/tpl_successDelete.php";
			include '../templates/tpl_main.php';
			exit();
		}
		catch (ErrorException $e){
			$output = 'Ошибка при добавлении записи о списании деталей в базу данных';
			include '../includes/output.html.php';
			exit(1);
		}
	}
}

if(!isset($_SESSION['model'])){
	$sql = "SELECT Id_C, Name FROM component WHERE is_atom != 1" ;
	$models = $db->select($sql);

	$pagetitle = "Cписание деталей";
	$tpl = "../templates/assembly/tpl_choiceDetails.php";
	include '../templates/tpl_main.php';
}
else{
	$id = $_SESSION['model'];
	$model_name = $_SESSION['model_name'];
	// выбор имени и количества деталей(запрос работает только для подсистем)
	$sql="SELECT  Name, Entities, count FROM tmp_detail_info JOIN tmp_storage_inventory ON Name = name_c 
													WHERE parent_id ={?} AND time = (SELECT max(time) FROM tmp_storage_inventory)" ;
	$details = $db->select($sql, array($id));
	
	// если модель - вернется пустой результат 
	if((count($details)) == 0){
		$sql="SELECT  Name, Entities, count FROM tmp_detail_info JOIN tmp_storage_inventory ON Name = name_c 
													WHERE parent_id = (SELECT tree_place FROM model WHERE component_id = {?}) 
													AND time = (SELECT max(time) FROM tmp_storage_inventory)" ;
		$details = $db->select($sql, array($id));
	}	
	
	if(( count($details)) != 0){
		$pagetitle = "Cписание деталей";
		$tpl = "../templates/assembly/tpl_detailShop.php";
		include '../templates/tpl_main.php';
		exit();
	}
	else{
		$error = "Нет данных для этой модели или подсистемы";
	}
}
?>