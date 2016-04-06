<?php
include '../includes/dbconnect.php';
include '../includes/execute_select.php';
include 'calculations/standartDeviation.php';

if(isset($_GET['Info'])){
    $sql = "SELECT overal_difference FROM reserve_stock WHERE YEAR(CURRENT_DATE) = year UNION SELECT overal_difference FROM reserve_stock WHERE YEAR(CURRENT_DATE) - year = 1 and month > MONTH(CURRENT_DATE)";
    $result = execute_select($pdo, $sql);

    while ( $row = $result->fetch() ) {
        $difference[]=$row['overal_difference'];
    }

    $sigma = standartDeviation($difference);
    echo $sigma;
    exit();
}

$pagetitle = "Страховой запас";
$tpl = "../templates/invoice/tpl_reserveForm.php";
include("../templates/tpl_main.php");
?>

