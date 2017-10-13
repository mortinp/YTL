<?php
App::uses('AppModel', 'Model');
App::uses('CakeTime', 'Utility');
App::uses('TimeUtil', 'Util');

class SharedTravel extends AppModel {
    
    public static $modalities = array(
        // El origin_id y el destination_id son indicadores unicos de cada lugar que se usan para recomendar transfers
        'HABTRI8'=>array('origin_id'=>0, 'destination_id'=>1, 'origin'=>'La Habana', 'destination'=>'Trinidad', 'time'=>'8 am (08:00 hrs)', 'price'=>35),
        'HABTRI14'=>array('origin_id'=>0, 'destination_id'=>1, 'origin'=>'La Habana', 'destination'=>'Trinidad', 'time'=>'2 pm (14:00 hrs)', 'price'=>35),
        'HABVIN8'=>array('origin_id'=>0, 'destination_id'=>2, 'origin'=>'La Habana', 'destination'=>'Viñales', 'time'=>'8 am (08:00 hrs)', 'price'=>25),
        'HABVIN14'=>array('origin_id'=>0, 'destination_id'=>2, 'origin'=>'La Habana', 'destination'=>'Viñales', 'time'=>'2 pm (14:00 hrs)', 'price'=>25),
        'HABVAR8'=>array('origin_id'=>0, 'destination_id'=>3, 'origin'=>'La Habana', 'destination'=>'Varadero', 'time'=>'8 am (08:00 hrs)', 'price'=>25),
        'HABVAR14'=>array('origin_id'=>0, 'destination_id'=>3, 'origin'=>'La Habana', 'destination'=>'Varadero', 'time'=>'2 pm (14:00 hrs)', 'price'=>25),
        'HABCFG8'=>array('origin_id'=>0, 'destination_id'=>4, 'origin'=>'La Habana', 'destination'=>'Cienfuegos', 'time'=>'8 am (08:00 hrs)', 'price'=>35),
        'HABCFG14'=>array('origin_id'=>0, 'destination_id'=>4, 'origin'=>'La Habana', 'destination'=>'Cienfuegos', 'time'=>'2 pm (14:00 hrs)', 'price'=>35),
        
        'TRIHAB8'=>array('origin_id'=>1, 'destination_id'=>0, 'origin'=>'Trinidad', 'destination'=>'La Habana', 'time'=>'8 am (08:00 hrs)', 'price'=>35),
        'TRIHAB14'=>array('origin_id'=>1, 'destination_id'=>0, 'origin'=>'Trinidad', 'destination'=>'La Habana', 'time'=>'2 pm (14:00 hrs)', 'price'=>35),
        //'TRIVIN8'=>array('origin_id'=>1, 'destination_id'=>2, 'origin'=>'Trinidad', 'destination'=>'Viñales', 'time'=>'8 am (08:00 hrs)', 'price'=>35),
        //'TRIVIN14'=>array('origin_id'=>1, 'destination_id'=>2, 'origin'=>'Trinidad', 'destination'=>'Viñales', 'time'=>'2 pm (14:00 hrs)', 'price'=>35),
        //'TRIVAR8'=>array('origin_id'=>1, 'destination_id'=>3, 'origin'=>'Trinidad', 'destination'=>'Varadero', 'time'=>'8 am (08:00 hrs)', 'price'=>35),
        //'TRIVAR14'=>array('origin_id'=>1, 'destination_id'=>3,'origin'=>'Trinidad', 'destination'=>'Varadero', 'time'=>'2 pm (14:00 hrs)', 'price'=>35),
        
        'VINHAB8'=>array('origin_id'=>2, 'destination_id'=>0, 'origin'=>'Viñales', 'destination'=>'La Habana', 'time'=>'8 am (08:00 hrs)', 'price'=>25),
        'VINHAB14'=>array('origin_id'=>2, 'destination_id'=>0, 'origin'=>'Viñales', 'destination'=>'La Habana', 'time'=>'2 pm (14:00 hrs)', 'price'=>25),
        //'VINTRI8'=>array('origin_id'=>2, 'destination_id'=>1, 'origin'=>'Viñales', 'destination'=>'Trinidad', 'time'=>'8 am (08:00 hrs)', 'price'=>25),
        //'VINTRI14'=>array('origin_id'=>2, 'destination_id'=>1, 'origin'=>'Viñales', 'destination'=>'Trinidad', 'time'=>'2 pm (14:00 hrs)', 'price'=>25),
        //'VINVAR8'=>array('origin_id'=>2, 'destination_id'=>3, 'origin'=>'Viñales', 'destination'=>'Varadero', 'time'=>'8 am (08:00 hrs)', 'price'=>25),
        //'VINVAR14'=>array('origin_id'=>2, 'destination_id'=>3, 'origin'=>'Viñales', 'destination'=>'Varadero', 'time'=>'2 pm (14:00 hrs)', 'price'=>25),
        //'VINCFG8'=>array('origin_id'=>2, 'destination_id'=>4, 'origin'=>'Viñales', 'destination'=>'Cienfuegos', 'time'=>'8 am (08:00 hrs)', 'price'=>35),
        //'VINCFG14'=>array('origin_id'=>2, 'destination_id'=>4, 'origin'=>'Viñales', 'destination'=>'Cienfuegos', 'time'=>'2 pm (14:00 hrs)', 'price'=>35),
        
        'VARHAB8'=>array('origin_id'=>3, 'destination_id'=>0, 'origin'=>'Varadero', 'destination'=>'La Habana', 'time'=>'8 am (08:00 hrs)', 'price'=>25),
        'VARHAB14'=>array('origin_id'=>3, 'destination_id'=>0, 'origin'=>'Varadero', 'destination'=>'La Habana', 'time'=>'2 pm (14:00 hrs)', 'price'=>25),
        //'VARTRI8'=>array('origin_id'=>3, 'destination_id'=>1, 'origin'=>'Varadero', 'destination'=>'Trinidad', 'time'=>'8 am (08:00 hrs)', 'price'=>25),
        //'VARTRI14'=>array('origin_id'=>3, 'destination_id'=>1, 'origin'=>'Varadero', 'destination'=>'Trinidad', 'time'=>'2 pm (14:00 hrs)', 'price'=>25),
        //'VARVIN8'=>array('origin_id'=>3, 'destination_id'=>2, 'origin'=>'Varadero', 'destination'=>'Viñales', 'time'=>'8 am (08:00 hrs)', 'price'=>25),
        //'VARVIN14'=>array('origin_id'=>3, 'destination_id'=>2, 'origin'=>'Varadero', 'destination'=>'Viñales', 'time'=>'2 pm (14:00 hrs)', 'price'=>25),
        //'VARCFG8'=>array('origin_id'=>3, 'destination_id'=>4, 'origin'=>'Varadero', 'destination'=>'Cienfuegos', 'time'=>'8 am (08:00 hrs)', 'price'=>35),
        //'VARCFG14'=>array('origin_id'=>3, 'destination_id'=>4, 'origin'=>'Varadero', 'destination'=>'Cienfuegos', 'time'=>'2 pm (14:00 hrs)', 'price'=>35),
        
        'CFGHAB8'=>array('origin_id'=>4, 'destination_id'=>0, 'origin'=>'Cienfuegos', 'destination'=>'La Habana', 'time'=>'8 am (08:00 hrs)', 'price'=>35),
        'CFGHAB14'=>array('origin_id'=>4, 'destination_id'=>0, 'origin'=>'Cienfuegos', 'destination'=>'La Habana', 'time'=>'2 pm (14:00 hrs)', 'price'=>35),
        //'CFGVIN8'=>array('origin_id'=>4, 'destination_id'=>2, 'origin'=>'Cienfuegos', 'destination'=>'Viñales', 'time'=>'8 am (08:00 hrs)', 'price'=>35),
        //'CFGVIN14'=>array('origin_id'=>4, 'destination_id'=>2, 'origin'=>'Cienfuegos', 'destination'=>'Viñales', 'time'=>'2 pm (14:00 hrs)', 'price'=>35),
        //'CFGVAR8'=>array('origin_id'=>4, 'destination_id'=>3, 'origin'=>'Cienfuegos', 'destination'=>'Varadero', 'time'=>'8 am (08:00 hrs)', 'price'=>35),
        //'CFGVAR14'=>array('origin_id'=>4, 'destination_id'=>3,'origin'=>'Cienfuegos', 'destination'=>'Varadero', 'time'=>'2 pm (14:00 hrs)', 'price'=>35),
        );
    
    public static $STATE_PENDING = 'P'; // Cuando se crea
    public static $STATE_ACTIVATED = 'A'; //Cuando se activa (se le envian los datos a Andiel para comenzar a gestionar)
    public static $STATE_CONFIRMED = 'C'; // Cuando se confirma que se puede realizar (Andiel confirma)
    
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