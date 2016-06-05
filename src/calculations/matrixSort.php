<?php
    function matrixSort($array, $by) {
        usort($array, function($first, $second) use( $by  ) {
            if ($first[$by]>$second[$by]) { return 1; }
            elseif ($first[$by]<$second[$by]) { return -1; }
            return 0;
        });
    }
?>