<?php
App::uses('AppModel', 'Model');
class DriverTravel extends AppModel {
    
    
    // Notifications Types (CUIDADO: NO CAMBIAR - Lo uso debajo en las cache_count del belongsTo(Travel))
    public static $NOTIFICATION_TYPE_AUTO = 'A'; // Para los choferes que se notifican al crearse el viaje
    public static $NOTIFICATION_TYPE_BY_ADMIN = 'M'; // Para los choferes que se notifican manualmente por un administrador
    public static $NOTIFICATION_TYPE_BY_USER = 'U'; // Para los choferes que el viajero decide notificar adicionalmente (ej. si nosotros le damos la opción)
    public static $NOTIFICATION_TYPE_PREARRANGED = 'R'; // Para los viajes que se le notifiquen a los choferes y hayan sido prearreglados (ej. para hacer un descuento)
    
    
    // Filters
    public static $SEARCH_ALL = 'all';
    public static $SEARCH_NEW_MESSAGES = 'new-messages';
    public static $SEARCH_FOLLOWING = 'following';
    public static $SEARCH_DONE = 'done';
    public static $SEARCH_PAID = 'paid';
    public static $SEARCH_PINNED = 'pinned';
    public static $SEARCH_ARCHIVED = 'archived';
    public static $filtersForSearch = array(
        'all'=>array('label'=>'Todas', 'title'=>''), 
        'new-messages'=>array('label'=>'Nuevos Mensajes', 'title'=>''), 
        'following'=>array('label'=>'Siguiendo', 'title'=>''), 
        'done'=>array('label'=>'Realizados', 'title'=>''), 
        'paid'=>array('label'=>'Pagados', 'title'=>''), 
        'pinned'=>array('label'=>'<i class="glyphicon glyphicon-pushpin"></i> Pineados', 'title'=>'Viajes que llevan una atención urgente. Revísalos cuanto antes!!!'), 
        'archived'=>array('label'=>'Archivados', 'title'=>''));
    
    
    public $order = 'Driver.id';
    
    public $useTable = 'drivers_travels';
    
    public $belongsTo = array(
        'Driver' => array(
            'fields'=>array('id', 'username', 'max_people_count'),
            'counterCache'=>'travel_count'
        ),
        'Travel'=>array(
            'fields'=>array('id', 'user_id', 'origin', 'destination', 'date', 'people_count'),
            'counterCache'=>array(
                'drivers_sent_by_admin_count'=>array('DriverTravel.notification_type'=>'M'),
                'drivers_sent_by_user_count'=>array('DriverTravel.notification_type'=>'U'))
        )
    );
    
    public $hasOne = array(
        'TravelConversationMeta'=>array(
            'foreignKey'=>'conversation_id'
        ),
    );
    
}

?>