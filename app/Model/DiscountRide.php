<?php
App::uses('AppModel', 'Model');
/**
 * DiscountRide Model
 *
 * @property Driver $Driver
 */
class DiscountRide extends AppModel {

    public $validate = array(
            'origin' => array(
                    'notempty' => array(
                            'rule' => array('notempty'),
                            //'message' => 'Your custom message here',
                            //'allowEmpty' => false,
                            //'required' => false,
                            //'last' => false, // Stop validation after this rule
                            //'on' => 'create', // Limit validation to 'create' or 'update' operations
                    ),
            ),
            'destination' => array(
                    'notempty' => array(
                            'rule' => array('notempty'),
                            //'message' => 'Your custom message here',
                            //'allowEmpty' => false,
                            //'required' => false,
                            //'last' => false, // Stop validation after this rule
                            //'on' => 'create', // Limit validation to 'create' or 'update' operations
                    ),
            ),
            'date' => array(
                    'date' => array(
                            'rule' => array('date'),
                            //'message' => 'Your custom message here',
                            //'allowEmpty' => false,
                            //'required' => false,
                            //'last' => false, // Stop validation after this rule
                            //'on' => 'create', // Limit validation to 'create' or 'update' operations
                    ),
            ),
            'hour_min' => array(
                    'numeric' => array(
                            'rule' => array('numeric'),
                            //'message' => 'Your custom message here',
                            //'allowEmpty' => false,
                            //'required' => false,
                            //'last' => false, // Stop validation after this rule
                            //'on' => 'create', // Limit validation to 'create' or 'update' operations
                    ),
            ),
            'hour_max' => array(
                    'numeric' => array(
                            'rule' => array('numeric'),
                            //'message' => 'Your custom message here',
                            //'allowEmpty' => false,
                            //'required' => false,
                            //'last' => false, // Stop validation after this rule
                            //'on' => 'create', // Limit validation to 'create' or 'update' operations
                    ),
            ),
            'price' => array(
                    'numeric' => array(
                            'rule' => array('numeric'),
                            //'message' => 'Your custom message here',
                            //'allowEmpty' => false,
                            //'required' => false,
                            //'last' => false, // Stop validation after this rule
                            //'on' => 'create', // Limit validation to 'create' or 'update' operations
                    ),
            ),
            'is_booked' => array(
                    'boolean' => array(
                            'rule' => array('boolean'),
                            //'message' => 'Your custom message here',
                            //'allowEmpty' => false,
                            //'required' => false,
                            //'last' => false, // Stop validation after this rule
                            //'on' => 'create', // Limit validation to 'create' or 'update' operations
                    ),
            ),
    );

    public $belongsTo = array(
        'Driver' => array(
            'className' => 'Driver',
            'foreignKey' => 'driver_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    
    public function afterFind($results, $primary = false) {
        foreach ($results as $key => $val) {
            
            $setPeopleCountFromDriver = 
                $val['DiscountRide']['people_count'] == null && isset($val['Driver']['max_people_count']);
                
            if($setPeopleCountFromDriver) $results[$key]['DiscountRide']['people_count'] = $val['Driver']['max_people_count'];
        }
        return $results;
    }
    
    public function findFullById($id) {
        $this->recursive = 3;
        $discount = $this->find('all', array('conditions'=>array('DiscountRide.id'=>$id)));
        if($discount == null) $discount[0] = null;//Artificio para si es invalido
        return $discount[0];
    }
}
