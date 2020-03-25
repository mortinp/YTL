<?php
App::uses('AppModel', 'Model');
App::uses('TimeUtil', 'Util');

class DriverTravel extends AppModel {
    
    // API
    public $actsAs = array(
        'ApiSync.Syncronizable'=>array(
            'sync_queue_table' => 'api_sync_queue_2driver_conversations',
            'key_field' => 'conversation_id',
            //'conditions' => array('notification_type' => 'A'/*DriverTravel::$NOTIFICATION_TYPE_AUTO*/)
        )
    );
    
    // Notifications Types (CUIDADO: NO CAMBIAR - Lo uso debajo en las cache_count del belongsTo(Travel))
    public static $NOTIFICATION_TYPE_AUTO = 'A'; // Para los choferes que se notifican al crearse el viaje
    public static $NOTIFICATION_TYPE_BY_ADMIN = 'M'; // Para los choferes que se notifican manualmente por un administrador
    //public static $NOTIFICATION_TYPE_BY_USER = 'U'; // Para los choferes que el viajero decide notificar adicionalmente (ej. si nosotros le damos la opción)
    public static $NOTIFICATION_TYPE_PREARRANGED = 'R'; // Para los viajes que se le notifiquen a los choferes y hayan sido prearreglados (ej. para hacer un descuento)
    public static $NOTIFICATION_TYPE_DIRECT_MESSAGE = 'D'; // Para las conversaciones directas (sin un viaje asociado)
    public static $NOTIFICATION_TYPE_DISCOUNT_OFFER_REQUEST = 'O'; // Para las ofertas de descuento
    public static $NOTIFICATION_TYPE_TOUR_REQUEST = 'T'; // Para los vintage cars
    
    
    // Filters
    public static $SEARCH_ALL = 'all';
    public static $SEARCH_NEW_MESSAGES = 'new-messages';
    public static $SEARCH_FOLLOWING = 'following';
    public static $SEARCH_DONE = 'done';
    public static $SEARCH_PAID = 'paid';
    public static $SEARCH_PINNED = 'pinned';
    public static $SEARCH_ARCHIVED = 'archived';
    public static $SEARCH_DIRECT_MESSAGES = 'direct-messages';
    public static $SEARCH_DISCOUNT_OFFER = 'discount-offers';
    public static $filtersForSearch = array(
        'all'=>array('label'=>'Todas', 'title'=>''), 
        'new-messages'=>array('label'=>'Nuevos Mensajes', 'title'=>''), 
        'following'=>array('label'=>'Siguiendo', 'title'=>''), 
        'done'=>array('label'=>'Realizados', 'title'=>''), 
        'paid'=>array('label'=>'Pagados', 'title'=>''), 
        'pinned'=>array('label'=>'<i class="glyphicon glyphicon-pushpin"></i> Pineados', 'title'=>'Viajes que llevan una atención urgente. Revísalos cuanto antes!!!'), 
        'archived'=>array('label'=>'Archivados', 'title'=>''),
        'direct-messages'=>array('label'=>'Mensajes Directos', 'title'=>''),
        'discount-offers'=>array('label'=>'Ofertas', 'title'=>''));
    
    
    public $order = 'Driver.id';
    
    public $useTable = 'drivers_travels';
    
    public $belongsTo = array(
        'Driver' => array(
            'fields'=>array('id', 'username', 'max_people_count', 'email_active'),
            'counterCache'=>'travel_count'
        ),
        'Travel'=>array(
            'fields'=>array('id', 'user_id', 'origin', 'destination', 'date', 'people_count'),
            'counterCache'=>array(
                'drivers_sent_by_admin_count'=>array('DriverTravel.notification_type'=>'M'),
                'drivers_sent_by_user_count'=>array('DriverTravel.notification_type'=>'U')/*,
                'drivers_replied_count'=>array('DriverTravel.message_count >'=>0)*/)
        ),
        'User' => array(
            'fields'=>array('id', 'username', 'role', 'lang', 'display_name', 'travel_count', 'conversations_count'),
            'counterCache'=>'conversations_count'
        )
    );
    
    public $hasOne = array(
        'TravelConversationMeta'=>array('foreignKey'=>'conversation_id'),
        /*'Testimonial' => array('foreignKey' => 'conversation_id')*/
    );
         
    
    public $validate = array(
        'travel_date' => array('rule' => 'notEmpty')
    );
    
    public function beforeSave($options = array()) {
        
        $isDirectMessage = 
                isset($this->data[$this->alias]['notification_type']) && 
                ($this->data[$this->alias]['notification_type'] == DriverTravel::$NOTIFICATION_TYPE_DIRECT_MESSAGE || $this->data[$this->alias]['notification_type'] == DriverTravel::$NOTIFICATION_TYPE_DISCOUNT_OFFER_REQUEST);
        $hasIdentifier = isset($this->data[$this->alias]['identifier']) && $this->data[$this->alias]['identifier'] != null;
        
        if( $isDirectMessage && !$hasIdentifier) {
            $nuevo = $this->query ('select coalesce(max(identifier) + 1, 1) as new_id  from drivers_travels');        
            $this->data[$this->alias]['identifier'] = $nuevo[0][0]['new_id'];//1 + $this->find('count', array('conditions' => array('DriverTravel.notification_type' => DriverTravel::$NOTIFICATION_TYPE_DIRECT_MESSAGES)));
        }    
        
        if (isset($this->data[$this->alias]['travel_date'])) {
            if($this->useDbConfig == 'mysql') {
                $d = str_replace('-', '/', $this->data[$this->alias]['travel_date']);
                $d = explode('/', $d);
                $newD = $d['2'].'-'.$d[1].'-'.$d[0];
                $this->data[$this->alias]['travel_date'] = $newD;
            }   
        }
        return true;
    }
    
    public function afterFind($results, $primary = false) {
        // Quitarle este comportamiento por si se vuelve a usar el DriverTravel para alguna búsqueda (ej. en la vista que genera esta accion, se llama a DriverTravel::getIdentifier(), que hace otra busqueda)
        if(AuthComponent::user('role') == 'operator')
            $this->Behaviors->unload('Operations.OperatorScope');
        
        foreach ($results as $key => $val) {
            if (isset($val[$this->alias]['travel_date'])) {
                $results[$key][$this->alias]['travel_date'] = TimeUtil::dateFormatAfterFind($val[$this->alias]['travel_date']);
                
                // Ponerle si está cerrada o no la conversacion
                if(DriverTravel::isClosed($val[$this->alias])) $val[$this->alias]['is_closed'] = true;
                else $val[$this->alias]['is_closed'] = true;
            }
        }
        return $results;
    }
    
    
    public function afterSave($created, array $options = array()) {
        parent::afterSave($created, $options);
        
        if($created) {
            CakeSession::write('Auth.User.conversations_count', CakeSession::read('Auth.User.conversations_count') + 1);
        }
    }
    
    public function afterDelete() {
        parent::afterDelete();
            
        CakeSession::write('Auth.User.conversations_count', CakeSession::read('Auth.User.conversations_count') - 1);
    }
    
    
    public static function getIdentifier($cid) {
        $id = null;
        
        if(is_array($cid)) {
            if(isset ($cid['DriverTravel'])) $cid = $cid['DriverTravel'];
            
            if(isset($cid['notification_type']) && $cid['notification_type'] == DriverTravel::$NOTIFICATION_TYPE_DIRECT_MESSAGE)
                $id = DriverTravel::$NOTIFICATION_TYPE_DIRECT_MESSAGE.$cid['identifier'];
            else if(isset($cid['notification_type']) && $cid['notification_type'] == DriverTravel::$NOTIFICATION_TYPE_DISCOUNT_OFFER_REQUEST)
                $id = DriverTravel::$NOTIFICATION_TYPE_DISCOUNT_OFFER_REQUEST.$cid['identifier'];
            else if(isset($cid['travel_id']) && $cid['travel_id'] != null)
                $id = $cid['travel_id'];
        } else {
            $DriverTravel = ClassRegistry::init('DriverTravel');  
            $DriverTravel->order = null;
            $conversation = $DriverTravel->find('first', array('conditions' => array('DriverTravel.id' => $cid), 'recursive' => -1));
            
            if( !isset($conversation['DriverTravel']['id']) ) return null;

            if( $conversation['DriverTravel']['notification_type'] == DriverTravel::$NOTIFICATION_TYPE_DIRECT_MESSAGE )
               $id = DriverTravel::$NOTIFICATION_TYPE_DIRECT_MESSAGE.$conversation['DriverTravel']['identifier'];
            else if( $conversation['DriverTravel']['notification_type'] == DriverTravel::$NOTIFICATION_TYPE_DISCOUNT_OFFER_REQUEST)
               $id = DriverTravel::$NOTIFICATION_TYPE_DISCOUNT_OFFER_REQUEST.$conversation['DriverTravel']['identifier'];
            else $id = $conversation['DriverTravel']['travel_id'];
        }
        
        return $id;
    }
    
    public static function prepare_direct_message(&$controller){
        $controller->Driver->attachProfile($controller->DriverTravel);
        $controller->DriverTravelerConversation->unbindModel(array('belongsTo' => array('DriverTravel')));
        $controller->DriverTravel->bindModel( array( 'hasMany' => array(
            'DriverTravelerConversation'=> array(
                'className'  => 'DriverTravelerConversation',
                'foreignKey' => 'conversation_id',
                'order'      => 'DriverTravelerConversation.id ASC',
                'limit'      => 1,
        ))));
    }
    
    /**
     * Esta funcion extrae la fecha dependiendo del tipo de conversacion que sea:
     * Si es una conversacion directa, extrae la fecha del DriverTravel.
     * Si no es directa la extrae del Travel
     */
    public static function extractDate($data) {
        $notificationType = null;
        $date = null;
        
        if(isset($data['DriverTravel'])) $notificationType = $data['DriverTravel']['notification_type'];
        
        $isDirectMessage = $notificationType == DriverTravel::$NOTIFICATION_TYPE_DIRECT_MESSAGE || $notificationType == DriverTravel::$NOTIFICATION_TYPE_DISCOUNT_OFFER_REQUEST;
        if($isDirectMessage) $date = $data['DriverTravel']['travel_date'];
        else
            if(isset($data['Travel'])) $date = $data['Travel']['date'];
        
        return $date;
    }
    
    /**
     * Esta funcion extrae el usuario dependiendo del tipo de conversacion que sea:
     * Si es una conversacion directa, extrae el usuario del DriverTravel.
     * Si no es directa lo extrae del Travel
     */
    public static function extractUSer($data) {
        $notificationType = null;
        $user = null;
        
        if(isset($data['DriverTravel'])) $notificationType = $data['DriverTravel']['notification_type'];
        
        if($notificationType == DriverTravel::$NOTIFICATION_TYPE_DIRECT_MESSAGE) {
            if(isset($data['User'])) $user = $data['User'];
            else if(isset($data['DriverTravel']['User'])) $user = $data['DriverTravel']['User'];
        }   
        else if(isset($data['Travel'])) {
           if(isset($data['User'])) $user = $data['User'];
            else if(isset($data['Travel']['User'])) $user = $data['Travel']['User'];
        }
        
        return $user;
    }
    
    public static function getConversationUrlArray($conversationId) {
        return array('controller'=>'driver_traveler_conversations', 'action'=>'view', $conversationId);
    }
    
    /**
     * Returns true or false whether this conversation is closed (does not accept new messages)
     */
    public static function isClosed($conversation) {
        if(isset($conversation['is_closed']) && $conversation['is_closed']) return true;
        
        $checkDate = strtotime('today - 2 month');
        $traveldate = strtotime($conversation['travel_date']);
               
        return $traveldate < $checkDate;
    }
    
}

?>