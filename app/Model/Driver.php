<?php
App::uses('AppModel', 'Model');
class Driver extends AppModel {
    
    public $order = 'travel_count DESC, id ASC';
    
    public $hasAndBelongsToMany = 'Locality';
    
    public $hasOne = array(
        'DriverProfile' => array(
            'fields'=>array('driver_nick', 'driver_name', 'avatar_filepath', 'show_profile')
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
        'min_people_count' => array(
            'isNumber' => array(
                'rule' => 'numeric',
                'message' => 'La cantidad de personas debe ser un número entero.',
                'required' => true
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
    
    public static function shortenName($name){
        $name = trim($name);
        
        // Eliminar todo despues de un espacio, ej. el apellido
        $split = str_getcsv($name, ' ');
        $name = $split[0];
        
        // Eliminar cualquier cosa entre parentesis, ej. (MITAXI)
        $split = str_getcsv($name, '(');
        $name = $split[0];
        
        $name = trim($name);
        
        return $name;
    }
    
    public static function removeParenthesisFromName($name) {
        $name = trim($name);
        
        // Eliminar cualquier cosa entre parentesis, ej. (MITAXI)
        $split = str_getcsv($name, '(');
        $name = $split[0];
        
        $name = trim($name);
        
        return $name;
    }
    
    
    /**
     * Esto es para coger el perfil del chofer
     * En cualquier momento se puede decir desde un controlador $this->Driver->attachProfile($finderModel)
     * 
     * @param $finderModel: El modelo desde el cual se va a hacer el find
     */ 
    
    public function attachProfile(&$finderModel) {
        $finderModel->recursive = 2;
        $this->unbindModel(array('hasAndBelongsToMany'=>array('Locality')));
    }
    
    
    
    public function getAsSuggestions($localityId = null) {
        $drivers = $this->find('all');
        $list = array();
        foreach ($drivers as $d) {
            $list[] = array('driver_id'=>$d['Driver']['id'], 'driver_username'=>$d['Driver']['username'], 'driver_name'=>$d['DriverProfile']['driver_name']);
        }  
        return $list;
    }
}

?>