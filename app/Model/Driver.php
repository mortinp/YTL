<?php
App::uses('AppModel', 'Model');
class Driver extends AppModel {
    
    public $order = 'travel_count DESC, id ASC';
    
    public $hasAndBelongsToMany = 'Locality';
    
    public $hasOne = array(
        'DriverProfile' => array(
            'fields'=>array('driver_name', 'avatar_filepath', 'show_profile')
        )
    );

    public $validate = array(
        'username' => array(
            'email' => array(
                'rule' => array('notEmpty'),
                'message' => 'El correo electrónico es obligatorio',
                'required' => true
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'La contraseña es obligatoria'
            )
        ),
        'description' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'La descripción es obligatoria.'
            )
        ),
        'max_people_count' => array(
            'isNumber' => array(
                'rule' => 'numeric',
                'message' => 'La cantidad de personas debe ser un número entero.',
                'required' => true
        )        
    ));

    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        return true;
    }
    
    public function loginExists($email) {
        return $this->find('first', array('conditions'=>array('username'=>$email))) != null;
    }
}

?>