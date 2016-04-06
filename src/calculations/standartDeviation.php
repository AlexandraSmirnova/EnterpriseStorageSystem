<?php

function standartDeviation($data){
    if(empty($data)){
        return 0;
    }
    $avg_array = array_sum($data) / count($data);
    $sum = 0;

    foreach($data as $x) {
        $sum += pow($x - $avg_array, 2);
    }

    $result = sqrt( $sum / count($data));
    return $result;
}
?>