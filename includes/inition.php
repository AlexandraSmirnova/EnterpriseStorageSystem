<?php
	$id_d=$_POST['id_d'];
	$count=$_POST['count'];
	$cost=$_POST['cost'];
	$date=$_POST['date'];
	$id_s=$_POST['id_s'];

	if(empty($date)){
		$error_str="Вы не указали дату";
	}
	if(preg_match("|([0-9]{4})-([0-1][0-9])-([0-3][0-9])|i", $date, $regs) && checkdate($regs[2], $regs[3], $regs[1])){
	}
	else{
		$error_str="Неверный формат даты";
	}
	if(empty($count)){
		$error_str="Вы не указали количество деталей";
	}

?>