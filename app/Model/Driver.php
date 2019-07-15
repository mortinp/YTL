<?php
App::uses('AppModel', 'Model');
App::uses('Testimonial', 'Model');
?>
<?php

class Driver extends AppModel {
    
    public $order = 'Driver.active DESC, Driver.operator_id DESC, Driver.id ASC';
    
    public $hasAndBelongsToMany = 'Locality';
    
    public $hasOne = array(
        'DriverProfile' => array(
            'fields'=>array('driver_nick', 'driver_name', 'avatar_filepath', 'show_profile', 'driver_code', 'description_en', 'description_es', 'featured_img_url')
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
        
        // Hack para manejar algunos nombres compuestos o complejos
        if(substr($name, 0, 11) == 'Juan Carlos') return 'Juan Carlos';
        if(substr($name, 0, 10) == 'Jorge Luis') return 'Jorge Luis';
        if(substr($name, 0, 11) == 'Dr. Lázaro') return 'Dr. Lázaro';
        if(substr($name, 0, 11) == 'José Angel') return 'José Angel';
        
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
         * que siempre que se llame restringir la notificacion de choferes si está logueado un operador.
         */
        if(AuthComponent::user('role') == 'operator')
            $this->Behaviors->load('Operations.OperatorScope', array('match'=>'Driver.operator_id', 'action'=>'N'));
        
        $drivers = $this->find('all', array('conditions'=>array('active'=>true, 'receive_requests'=>true, 'role'=>'driver')));
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
    
    public function getDriversCardsByProvince($provinceID) {
        return 
        $this->query(
                "SELECT drivers_profiles.*, drivers.*, COUNT(travels.id) as travel_count, SUM(travels.people_count) as total_travelers, testimonials.review_count, testimonials.latest_testimonial_date,
                 latest_testimonial.author, latest_testimonial.text, latest_testimonial.country

                FROM drivers
                
                INNER JOIN drivers_profiles ON drivers.id = drivers_profiles.driver_id AND drivers.active = true AND drivers.province_id=".$provinceID." 
                
                INNER JOIN drivers_travels ON drivers.id = drivers_travels.driver_id 
                
                INNER JOIN travels_conversations_meta ON drivers_travels.id = travels_conversations_meta.conversation_id AND travels_conversations_meta.state IN ('D', 'P')

                LEFT JOIN travels ON travels.id = drivers_travels.travel_id

                LEFT JOIN (
                    SELECT drivers.id as driver_id, COUNT(testimonials.id) as review_count, max(testimonials.created) as latest_testimonial_date
                    FROM testimonials
                    INNER JOIN drivers ON drivers.id = testimonials.driver_id AND testimonials.state = 'A'
                    GROUP BY drivers.id
                    ORDER BY drivers.id
                ) testimonials
                ON testimonials.driver_id = drivers.id
                
                LEFT JOIN (
                    SELECT author, text, country, driver_id
                    FROM testimonials
                    WHERE lang = '".Configure::read('Config.language')."'
                    GROUP BY driver_id
                    ORDER BY created DESC
                ) latest_testimonial
                ON latest_testimonial.driver_id = drivers.id

                GROUP BY drivers.id

                ORDER BY testimonials.latest_testimonial_date DESC"
                );
    }
    
    public function getNextToNotify($provinceID, $count = 6, $notThisDriverId = null) {
        $notThisDriverCondition = '';
        if($notThisDriverId != null) $notThisDriverCondition = 'AND drivers.id != '.$notThisDriverId;
        
        return 
        $this->query(
                "SELECT drivers_profiles.*, drivers.*, COUNT(travels.id) as travel_count, SUM(travels.people_count) as total_travelers

                FROM drivers
                
                INNER JOIN drivers_profiles 
                ON drivers.id = drivers_profiles.driver_id 
                AND drivers.active = true 
                AND drivers.receive_requests = true 
                AND drivers.province_id=".$provinceID."
                ".$notThisDriverCondition."
                    
                INNER JOIN drivers_travels ON drivers.id = drivers_travels.driver_id 
                
                INNER JOIN travels_conversations_meta ON drivers_travels.id = travels_conversations_meta.conversation_id AND travels_conversations_meta.state IN ('D', 'P')

                LEFT JOIN travels ON travels.id = drivers_travels.travel_id

                GROUP BY drivers.id

                ORDER BY drivers.last_notification_date ASC
                LIMIT ".$count
                );
    }
}

?>