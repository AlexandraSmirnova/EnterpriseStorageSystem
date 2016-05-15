<?php
$details = array();

if($models) {

    foreach ($models as $model) {
        $id = $model['id_model'];
        $plan_count = $model['count'];
        $details_of_model = getModelComposite($db, $id);
        
        foreach ($details_of_model as $item) {
            $needle = $item["name"];
            // поиск записи о детали в $details
            $result = array_filter($details, function ($innerArray) {
                global $needle;
                //return in_array($needle, $innerArray);    //Поиск по всему массиву
                return ($innerArray['name'] == $needle); //Поиск по первому значению
            });

            $indexes = array_keys($result);
            $index = $indexes[0];
            
            if (isset($index)) {
                $details[$index]['entities'] += $item['entities'];
                $details[$index]['required'] += $item['entities'] * $plan_count;
                if ($model['start_production'] < $details[$index]['date_required']) {
                    $details[$index]['date_required'] = $model['start_production'];
                }
            } else {
                $details[] = array_merge($item, array('required' => $item['entities'] * $plan_count, 'date_required' => $model['start_production']));
            }
        }
    }
}
?>