<?php
App::uses('AppModel', 'Model');
App::uses('CakeTime', 'Utility');
App::uses('TimeUtil', 'Util');

class SharedTravel extends AppModel {
    
    public static $modalities = array(
        'HABTRI8'=>array('origin'=>'La Habana', 'destination'=>'Trinidad', 'time'=>'8 am (08:00 hrs)', 'price'=>35),
        'HABTRI14'=>array('origin'=>'La Habana', 'destination'=>'Trinidad', 'time'=>'2 pm (14:00 hrs)', 'price'=>35),
        'HABVIN8'=>array('origin'=>'La Habana', 'destination'=>'Viñales', 'time'=>'8 am (08:00 hrs)', 'price'=>25),
        'HABVIN14'=>array('origin'=>'La Habana', 'destination'=>'Viñales', 'time'=>'2 pm (14:00 hrs)', 'price'=>25),
        'HABVAR8'=>array('origin'=>'La Habana', 'destination'=>'Varadero', 'time'=>'8 am (08:00 hrs)', 'price'=>25),
        'HABVAR14'=>array('origin'=>'La Habana', 'destination'=>'Varadero', 'time'=>'2 pm (14:00 hrs)', 'price'=>25)
        );
    
    public static $STATE_PENDING = 'P'; // Cuando se crea
    public static $STATE_ACTIVATED = 'A'; //Cuando se activa (se le envian los datos a Andiel para comenzar a gestionar)
    public static $STATE_CONFIRMED = 'C'; // Cuando se confirma que se puede realizar
    
    public $validate = array(
        'date' => array(
            'isDate' => array(
                'rule' => array('date', array('dmy', 'ymd')),
                'message' => 'La fecha tiene un formato incorrecto.',
                'required' => true
            )
        ),
        'people_count' => array(
            'isNumber' => array(
                'rule' => 'numeric',
                'message' => 'La cantidad de personas debe ser un número entero.',
                'required' => true
            ),
            'notZero' => array(
                'rule' => array('comparison', '>=', 1),
                'message' => 'La cantidad de personas no puede ser 0.',
                'required' => true
            )
        )
    );
    
    
    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['date'])) {
            if($this->useDbConfig == 'mysql') {
                // Guardar como YYYY/mm/dd
                $d = str_replace('-', '/', $this->data[$this->alias]['date']);
                $d = explode('/', $d);
                $newD = $d['2'].'-'.$d[1].'-'.$d[0];
                $this->data[$this->alias]['date'] = $newD;
            }   
        }
        return true;
    }
    
    public function afterFind($results, $primary = false) {
        foreach ($results as $key => $val) {
            if (isset($val[$this->alias]['date'])) {
                $results[$key][$this->alias]['date'] = TimeUtil::dateFormatAfterFind($val[$this->alias]['date']);
                
                $date_converted = strtotime($val[$this->alias]['date']);
                $expired = CakeTime::isPast($date_converted) && !CakeTime::isToday($date_converted);
                $results[$key][$this->alias]['is_expired'] = $expired;
            }
        }
        return $results;
    }
}

?>