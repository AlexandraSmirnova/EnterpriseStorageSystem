<?php



class LaplasTable {
    private static $table = null;
    private static $laplasArray =array();

    public static function getTable() {
        if (self::$table == null) self::$table = new LaplasTable();
        return self::$table;
    }
    
    private function __construct() {
        require('binarySearch.php');
        $precision = 0.001;
        self::$laplasArray['t'] = array();
        self::$laplasArray['f'] = array();
        for ( $t = 0.0 ; $t < 3.99 ; $t += 0.02 ){
            self::$laplasArray['t'][] = $t;
            self::$laplasArray['f'][] = $this->calculateLaplas($t, $precision);
            //echo self::$laplasArray['t'][$i]." : ".self::$laplasArray['f'][$i]."<br>";
        }
    }


    public function getArray(){
        return self::$laplasArray;
    }
    
    // Функция, возвращающая аргумент по значению функции Лапласа
    public function getParameter($probability)
    {
        $index = binarySearch(self::$laplasArray['f'], $probability);
        return self::$laplasArray['t'][$index];
    }

    public function calculateLaplas($arg, $precision) {
        $result = 0.0;

        for( $i = 0 ; $i < $arg ; $i += $precision ) {
            $result += $precision * ( abs( pow( M_E, -0.5 * pow( $i, 2 ) ) + pow( M_E, -0.5 * pow( $i + $precision, 2 ) ) ) ) / 2.0;
        }
        $result *= 2.0 / pow( 2.0 * M_PI, 0.5);
        return round($result, 5);
    }
}

?>