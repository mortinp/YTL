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
            'fields'=>array('id', 'user_id')
        )
    );
}

?>