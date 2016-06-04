<?php 

if(isset($_GET['id_m'])){
	$id_m = $_GET['id_m'];	
	$model = $_GET['name_m'];	
}
else{
//TODO output
	exit();
}

require('db_api/dataBase.php');
$db = DataBase::getDB();
/**
 * @param $model_id
 */
function ShowModel($model_id){
	global $db;
	
	$sql = "SELECT * from tmp_index_tree WHERE rid = {?} ";
	$result = $db->select($sql, array($model_id));
	
	$lvl=0;
	foreach ( $result as $row ) {
		if($row["level"] > $lvl){
			$lvl++;
			echo("<ul>\n");
		}
		else if($row["level"] < $lvl){
			while ($row["level"] < $lvl ){
				$lvl--;
				echo("</ul>\n");
			}
		}
		echo("<li>\n");
		echo(" ".$row["name"]."");
		if($lvl > 0)
			echo(" - ".$row["entities"]."");
		echo("</li>"."  \n");
	}
	
	while($lvl > 0){
		$lvl--;
		echo("</ul>\n");
	}
}

$pagetitle = "Модели";
$tpl = "../templates/model/tpl_modelTree.php";
include("../templates/tpl_main.php");

$sql="SELECT tree_place FROM model WHERE Id_M = {?}" ;
$result = $db->select($sql, array($id_m));

echo("<div class='center-block'>");
echo("<div class='tree-structure'>");
echo("<ul>\n");
foreach ($result as $row )
	ShowModel($row["tree_place"]);			
echo("</ul>\n");
echo("</div>");
echo("</div>");
?>