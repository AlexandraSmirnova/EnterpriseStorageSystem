<?php 

if(isset($_GET['id_m'])){
	$id_m = $_GET['id_m'];	
	$model = $_GET['name_m'];	
}
else{
//TODO output
	exit();
}

include( "../includes/dbconnect.php" ); 
include( "../includes/execute_select.php" );


/**
 * @param $model_id
 */
function ShowModel($model_id){
	global $pdo; 
	
	$sql = "SELECT * from tmp_index_tree WHERE rid = ".$model_id." ";
	$result = execute_select($pdo, $sql);
	
	$lvl=0;
	while ( $row = $result->fetch() ) {
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

$sql="SELECT tree_place FROM Model WHERE component_id =".$id_m."" ;
$result = execute_select($pdo, $sql);

echo("<div class='center-block'>");
echo("<ul class='tree-structure'>\n");
while ( $row = $result->fetch() )
	ShowModel($row["tree_place"]);			
echo("</ul>\n");
echo("</div>");

?>