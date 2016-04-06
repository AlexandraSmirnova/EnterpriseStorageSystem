<?php
session_start();
include '../includes/dbconnect.php'; 
include '../includes/execute_select.php';

if(isset($_GET['Info'])){		
	$_SESSION['model'] =  $_POST['id'];	
	$sql = "SELECT Name FROM Component WHERE Id_C = ".$_SESSION['model']."";
	$result = execute_select($pdo, $sql);
	$_SESSION['model_name'] = $result->fetch();	
} 

if(!isset($_SESSION['name'])){ //Если массив под названием item _id не инициализирован, то инициализаруем его	
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
			$sql= 'INSERT INTO expenditure 
						SET component =:id_d, count=:count,  date=NOW()';
			$s=$pdo->prepare($sql);
			$s->bindValue(':id_d', $_SESSION['name'][$i]);			
			$s->bindValue(':count', $_SESSION['count'][$i]);			
			$s->execute();
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
		catch (PDOexception $e){
			$output = 'Ошибка при добавлении записи о списании деталей в базу данных';
			include '../includes/output.html.php';
			exit(1);
		}
	}
}

if(!isset($_SESSION['model'])){	
	
	$sql = "SELECT Id_C, Name FROM Component WHERE is_atom != 1" ;
	$result = execute_select($pdo, $sql);
			
	while ( $row = $result->fetch() ) {
		$models[]=array('id'=>$row['Id_C'], 'name'=>$row['Name']);		
	}
		
	$pdo = null;

	$pagetitle = "Cписание деталей";
	$tpl = "../templates/assembly/tpl_choiceDetails.php";
	include '../templates/tpl_main.php';
}
else{
	$id = $_SESSION['model'];
	$model_name = $_SESSION['model_name'];
	// выбор имени и количества деталей(запрос работает только для подсистем)
	$sql="SELECT  Name, Entities, count FROM tmp_detail_info JOIN tmp_storage_inventory ON Name = name_c 
													WHERE parent_id = ".$id." AND time = (SELECT max(time) FROM tmp_storage_inventory)" ;
	$result = execute_select($pdo, $sql);
	
	// если модель - вернется пустой результат 
	if(($result -> rowCount()) == 0){
		$sql="SELECT  Name, Entities, count FROM tmp_detail_info JOIN tmp_storage_inventory ON Name = name_c 
													WHERE parent_id = (SELECT tree_place FROM Model WHERE component_id = $id) 
													AND time = (SELECT max(time) FROM tmp_storage_inventory)" ;
		$result = execute_select($pdo, $sql);
	}	
	
	if(($result -> rowCount()) != 0){
		while ( $row = $result->fetch()  ) {
			$details[]=array('name'=>$row['Name'], 'count'=>$row['Entities'], 'storage'=>$row['count'] );
		}
		
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