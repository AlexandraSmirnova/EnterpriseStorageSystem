<?php
require('../db_api/dataBase.php');
$db = DataBase::getDB();
include '../db_api/getModelInfo.php';

$all_models = getModelList($db);
echo json_encode($all_models);
?>

