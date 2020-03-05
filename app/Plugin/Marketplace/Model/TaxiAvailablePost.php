<?php
App::uses('AppModel', 'Model');
App::uses('CakeTime', 'Utility');
App::uses('TimeUtil', 'Util');

class TaxiAvailablePost extends AppModel {
    
    public $useTable = 'marketplace_taxi_available_posts';
    
    /*public static $localities = array(
        0=>'La Habana',
        2=>'Viñales',
        3=>'Varadero',
        7=>'Santa Clara',
        10=>'Cayo Santa María',
        8=>'Playa Larga', 
        9=>'Playa Girón',
        4=>'Cienfuegos',
        1=>'Trinidad',
        5=>'Cayo Coco', 
        6=>'Cayo Guillermo',
    );*/
    
    public static $localities = array(
        0=>array('name'=>'La Habana', 'slug'=>'habana', 'code'=>'HAB', 'short'=>'Hab', 'order'=>1),
        2=>array('name'=>'Viñales', 'slug'=>'vinales', 'code'=>'VIN', 'short'=>'Viñ', 'order'=>2), 
        3=>array('name'=>'Varadero', 'slug'=>'varadero', 'code'=>'VAR', 'short'=>'Var', 'order'=>3),
        9=>array('name'=>'Playa Girón', 'slug'=>'playa-giron', 'code'=>'PLG', 'short'=>'P. Giron', 'order'=>4),
        8=>array('name'=>'Playa Larga', 'slug'=>'playa-larga', 'code'=>'PLL', 'short'=>'P. Larga', 'order'=>5),
        7=>array('name'=>'Santa Clara', 'slug'=>'santa-clara', 'code'=>'SCL', 'short'=>'S. Clara', 'order'=>6),
        10=>array('name'=>'Cayo Santa María', 'slug'=>'cayo-santa-maria', 'code'=>'CSM', 'short'=>'C. Sta Maria', 'order'=>7),
        4=>array('name'=>'Cienfuegos', 'slug'=>'cienfuegos', 'code'=>'CFG', 'short'=>'Cfg', 'order'=>8),
        1=>array('name'=>'Trinidad', 'slug'=>'trinidad', 'code'=>'TRI', 'short'=>'Tri', 'order'=>9),
        5=>array('name'=>'Cayo Coco', 'slug'=>'cayo-coco', 'code'=>'CAC', 'short'=>'C. Coco', 'order'=>10),
        6=>array('name'=>'Cayo Guillermo', 'slug'=>'cayo-guillermo', 'code'=>'CAG', 'short'=>'C. Guillermo', 'order'=>11),
        
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
        if (isset($this->data[$this->alias]['email'])) {
            $this->data[$this->alias]['email'] = strtolower($this->data[$this->alias]['email']);
        }
        if (isset($this->data[$this->alias]['contact_phone_number'])) {
            $phoneNumber = $this->data[$this->alias]['contact_phone_number'];
            
            // Coger los ultimos 8 numeros y ponerle +53 delante
            $phoneNumber = '+53'.substr ($phoneNumber, -8);
            
            $this->data[$this->alias]['contact_phone_number'] = $phoneNumber;
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