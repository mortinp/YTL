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
    
    public static function prettyName($user, $showRole = false) {
        $pretty_user_name = "Desconocido";
        
        if($user == null) return $pretty_user_name;

        if($user['display_name'] != null) {
            $splitName = explode('@', $user['display_name']);
            if(count($splitName) > 1) $pretty_user_name = $splitName[0];
            else $pretty_user_name = $user['display_name'];
        } else {
            $splitEmail = explode('@', $user['username']);
            $pretty_user_name = $splitEmail[0];
        }

        if($showRole) {
            $role = $user['role'];
            if($role === 'admin' || $role === 'tester' || $role === 'operator') $pretty_user_name.= ' (<b>'.$role.'</b>)';
        }
        
        return $pretty_user_name;
    }
    
    public function getOperatorsList($addNullOperator = false) {
        $ops = $this->find('list', array('conditions'=>array('role'=>'operator'), 'fields'=>array('id', 'display_name')));
        
        if($addNullOperator) {
            $tmp = $ops;
            $ops = array(0=>'--- Ninguno ---');
            foreach ($tmp as $key => $value) {
                $ops[$key] = $value;
            }
        }
        
        return $ops;
    }
}

?>