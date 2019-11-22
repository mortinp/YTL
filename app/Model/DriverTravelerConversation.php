<?php
App::uses('AppModel', 'Model');
class DriverTravelerConversation extends AppModel {
    
    // API
    public $actsAs = array(
        'ApiSync.Syncronizable'=>array(
            'sync_queue_table' => 'api_sync_queue_2driver_conversations',
            'key_field' => 'msg_id',
            'fields'=>array('conversation_id'=>'conversation_id'),
            'conditions' => array('response_by' => 'traveler')
        )
    );
    
    public static $STATE_NONE = 'N';
    public static $STATE_TRAVEL_DONE = 'D';
    public static $STATE_TRAVEL_NOT_DONE = 'X';
    public static $STATE_TRAVEL_PAID = 'P';
    
    public $order = 'id';
    
    public $belongsTo = array(
        'DriverTravel' => array(
            'counterCache'=>'message_count',
            'foreignKey'=>'conversation_id',
            'fields'=>array('') // Vacio porque esto es solo para la counterCache
        ),
    );
    
    public function afterFind($results, $primary = false) {
        
        // Quitarle este comportamiento por si se vuelve a usar el DriverTravel para alguna busqueda (ej. en la vista que genera esta accion, se llama a DriverTravel::getIdentifier(), que hace otra busqueda)
        if(AuthComponent::user('role') == 'operator')
            $this->Behaviors->unload('Operations.OperatorScope');
        
        $userIsAdmin = in_array(AuthComponent::user('role'), array('admin', 'operator'));
        
        // Quitarle todos los datos de contacto al mensaje si el usuario no es un admin
        if(!$userIsAdmin) {
            foreach ($results as $key => $val) {
                if (isset($val[$this->alias]['response_text'])) {
                    $results[$key][$this->alias]['response_text'] = EmailsUtil::removeAllContactInfo($results[$key][$this->alias]['response_text']);
                }
            }
        }
        
        return $results;
    }
    
}

?>