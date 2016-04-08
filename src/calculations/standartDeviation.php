<?php
include "laplasFunction.php";

function standartDeviation($data){
    if(empty($data)){
        return 0;
    }
    echo "count - ".count($data)."<br>";
    $avg_array = array_sum($data) / count($data);
    $sum = 0;
    echo "avg - ".$avg_array."<br>";
    foreach($data as $x) {
        $sum += pow($x - $avg_array, 2);
    }

    $result = sqrt( $sum / count($data));
    return ceil($result * laplas(0.97));
}
?>