<?php
/*
*  Функция для бинарного поиска элемента в упорядоченном массиве.
*  Если искомых элементов в массиве несколько - возвращается первый из них.
*  В случае, если массив пуст или искомое значение находится за пределами массива,
*  возвращается false.
* @param array $searchArray Отсортированный массив
* @param int $needle Искомое значение
* @return false|int вернёт позицию (int) искомого элемента в массиве или
* вернёт false в случае, если элемент не найден или в случае какой-либо ошибки
*/
function binarySearch(array $searchArray, $needle) {
    $arrayLength = sizeof($searchArray);
    $eps = 0.01;
    /* Проверка на пустой массив или позицию за пределами массива */
    if (!$arrayLength || $needle < $searchArray[0] || $needle > $searchArray[$arrayLength - 1]) {
        return false;
    }
    $leftPosition = 0;
    $rightPosition = $arrayLength - 1;
    $returnPosition = false;

    while ( $leftPosition < $rightPosition ) {
    // Делим массив напополам
        $middlePosition = (int)floor($leftPosition + ($rightPosition - $leftPosition) / 2);

        if ( $needle <= $searchArray[$middlePosition] ) {
            $rightPosition = $middlePosition;
        } else {
            $leftPosition = $middlePosition + 1;
        }
    }

    /* Искомый элемент найден. $rightPosition - позиция искомого элемента */
    if ( $searchArray[$rightPosition] <= $needle + $eps  && $searchArray[$rightPosition] >= $needle - $eps ) {
        $returnPosition = $rightPosition;
    }

    return $returnPosition;
}
