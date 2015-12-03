<?php
App::uses('AppModel', 'Model');
class DriverTravel extends AppModel {
    
    public $order = 'Driver.id';
    
    public $useTable = 'drivers_travels';
    
    public $belongsTo = array(
        'Driver' => array(
            'fields'=>array('id', 'username', 'max_people_count'),
            'counterCache'=>'travel_count'
        ),
        'Travel'=>array(
            'fields'=>array('id', 'user_id', 'origin', 'destination', 'date', 'people_count')
        )
    );
    
    public $hasOne = array(
        'TravelConversationMeta'=>array(
            'foreignKey'=>'conversation_id'
        ),
    );
    
    
    // Notifications Types
    public static $NOTIFICATION_TYPE_AUTO = 'A'; // Para los choferes que se notifican al crearse el viaje
    public static $NOTIFICATION_TYPE_MANUAL = 'M'; // Para los choferes que se notifican manualmente
    public static $NOTIFICATION_TYPE_EXTRA = 'E'; // Para los choferes que el viajero decide notificar adicionalmente (ej. si nosotros le damos la opción)
    
    
    // Filters
    public static $SEARCH_ALL = 'all';
    public static $SEARCH_NEW_MESSAGES = 'new-messages';
    public static $SEARCH_FOLLOWING = 'following';
    public static $SEARCH_DONE = 'done';
    public static $SEARCH_PAID = 'paid';
    public static $filtersForSearch = array('all', 'new-messages', 'following', 'done', 'paid');
}

?>