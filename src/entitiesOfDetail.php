<?php
require('classes/dataBase.php');
$db = DataBase::getDB();

$sql = "SELECT id, name, parent, entities from tmp_detail_info WHERE name = {?}" ;
$details = $db->select($sql, array($detail));
		
if(empty($details)){
	$output = "Деталь не используется ни в одной из моделей";	
}

$pagetitle = "Детали";
$tpl = "../templates/detail/tpl_detailEntities.php";
include("../templates/tpl_main.php");
?>