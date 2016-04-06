<?php
function execute_select($pdo, $sql){
	try{
		$result= $pdo->query($sql);
	}
	catch (PDOException $e){
		$output = 'Ошибка при извлечении данных ';
		include 'output.html.php';
		exit();
	}
	
	if(empty($result)){
		$output = 'Ошибка. Нет данных';
		include 'output.html.php';
		exit();
	}
	
	return $result;

}
?>