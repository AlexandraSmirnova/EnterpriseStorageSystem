<?php
require('../db_api/dataBase.php');
$db = DataBase::getDB();

if ($_POST) {
    try{
        $query = "INSERT INTO production_plan
						SET id_model={?}, count={?}, start_production={?}";
        $id_i =  $db->query($query, array($_POST['id'], $_POST['count'], $_POST['date']));

        $response = array('status' => '200', 'id' => $_POST['id'], 'count' => $_POST['count'], 'date' => $_POST['date']);
    }
    catch (ErrorException $e){
        $response = array('status' => '403', 'error' => 'Не получилось добавить план. Возможно недостаточно прав');

    }

    echo json_encode($response);
}

?>