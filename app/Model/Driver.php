<?php
App::uses('AppModel', 'Model');
App::uses('Testimonial', 'Model');
?>
<?php

class Driver extends AppModel {
    
    public $order = 'travel_count DESC, Driver.id ASC';
    
    public $hasAndBelongsToMany = 'Locality';
    
    public $hasOne = array(
        'DriverProfile' => array(
            'fields'=>array('driver_nick', 'driver_name', 'avatar_filepath', 'show_profile', 'driver_code', 'description_en', 'description_es')
        )
    );
    
    public $belongsTo = array(
        'Province' => array(
            'fields'=>array('id', 'name')
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
        
        if (isset($this->data[$this->alias]['operator_id']) && $this->data[$this->alias]['operator_id'] == 0 /*Ningun operador*/) {
            $this->data[$this->alias]['operator_id'] = null;
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
        $this->unbindModel(array('hasAndBelongsToMany'=>array('Locality'))); // Para que no se carguen las localidades del chofer
    }
    
    public function unloadProfile(&$finderModel) {
        $this->unbindModel(array('hasOne'=>array('DriverProfile')));
    }
    
    public function loadTestimonials(&$finderModel) {
        $finderModel->recursive = 2;
        $this->unbindModel(array('hasAndBelongsToMany'=>array('Locality')));
        $this->bindModel(array('hasMany'=>array('Testimonial'=>array('conditions'=>array('Testimonial.state'=>Testimonial::$statesValues['approved']), 'order'=>'Testimonial.created DESC'))));
    }
    
    
    // TODO: Ponerle como nombre a esta funcion: getNotificationList
    public function getAsSuggestions($localityId = null) {
        /**
         * Aqui asumo que cuando se llama a esta funcion, es porque en la vista se va a permitir notificar a mas choferes. Entonces, lo mejor es
         * que siempre que se llame restringir la notificacion se choferes si esta logueado un operador.
         */
        if(AuthComponent::user('role') == 'operator')
            $this->Behaviors->load('Operations.OperatorScope', array('match'=>'Driver.operator_id', 'action'=>'N'));
        
        $drivers = $this->find('all', array('conditions'=>array('active'=>true)));
        $list = array();
        foreach ($drivers as $d) {
            $list[] = array(
                'driver_id'=>$d['Driver']['id'], 
                'driver_username'=>$d['Driver']['username'], 
                'driver_name'=>$d['DriverProfile']['driver_name'],
                'driver_pax'=>$d['Driver']['min_people_count'].'-'.$d['Driver']['max_people_count'],
                'province_id'=>$d['Province']['id'],
                'province_name'=>$d['Province']['name']);
        }  
        return $list;
    }
}

?>