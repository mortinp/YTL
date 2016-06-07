<?php

App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');

class User extends AppModel {
    
    public $order = 'id';

    public $validate = array(
        'username' => array(
            'email' => array(
                'rule' => array('notEmpty'),
                'message' => 'El correo electrónico es obligatorio.',
                'required' => true
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'La contraseña es obligatoria.'
            ),
            /*'minLength' => array(
                'rule' => array('minLength', 7),
                'message' => 'La contraseña debe tener al menor 7 caracteres.',
                'required' => true
            )*/
        ),
        'role' => array(
            'valid' => array(
                'rule' => array('inList', array('admin', 'driver', 'regular', 'tester', 'operator')),
                'message' => 'Por favor, entre un rol válido.',
                'allowEmpty' => false
            )
        ),
        
    );

    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        return true;
    }
    
    public function loginExists($email) {
        return $this->find('first', array('conditions'=>array('username'=>$email))) != null;
    }
    
    public static function canCreateTravel() {
        return AuthComponent::user('travel_count') < 1 || AuthComponent::user('email_confirmed');
    }
    
    public static function isRegular($user = null) {
        if($user != null) return $user['role'] === 'regular';
        return AuthComponent::user('role') === 'regular';
    }
}

?>