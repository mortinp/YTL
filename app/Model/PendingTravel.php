<?php
App::uses('AppModel', 'Model');
class PendingTravel extends AppModel {
    
    public $order = 'PendingTravel.id DESC';
    
    public $belongsTo = array(
        'Locality' => array(
            'fields'=>array('id', 'name')
        )
    );

    public $validate = array(
        'where' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'El destino no puede estar vacío.'
            )
        ),
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
        ),
        'details' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Debe escribir los detalles del viaje.'
            )
        ),
        'email' => array(
            'email' => array(
                'rule' => array('notEmpty'),
                'message' => 'El correo electrónico es obligatorio.',
                'required' => true
            )
        )
    );
    
    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['date'])) {
            if($this->useDbConfig == 'mysql') {
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
                $results[$key][$this->alias]['date'] = $this->dateFormatAfterFind($val[$this->alias]['date']);
            }
        }
        return $results;
    }
    
    public function dateFormatAfterFind($date) {
        return date('d-m-Y', strtotime($date));
    }
}

?>