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
            'fields'=>array('id', 'user_id', 'origin', 'destination', 'date')
        )
    );
    
    public $hasOne = array(
        'TravelConversationMeta'=>array(
            'foreignKey'=>'conversation_id'
        ),
    );
    
    
    // Filters
    public static $SEARCH_ALL = 'all';
    public static $SEARCH_NEW_MESSAGES = 'new-messages';
    public static $SEARCH_FOLLOWING = 'following';
    public static $SEARCH_DONE = 'done';
    public static $SEARCH_PAID = 'paid';
    public static $filtersForSearch = array('all', 'new-messages', 'following', 'done', 'paid');
}

?>