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
    
}

?>