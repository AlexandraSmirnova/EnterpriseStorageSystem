<?php
include('db_api/getDetailInfo.php');
require('db_api/dataBase.php');
$db = DataBase::getDB();

$details = getEntitiesOfDetail($db, $detail);
		
if(empty($details)){
	$output = "Деталь не используется ни в одной из моделей";	
}

$pagetitle = "Детали";
$tpl = "../templates/detail/tpl_detailEntities.php";
include("../templates/tpl_main.php");
?>