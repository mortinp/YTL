<?php
App::uses('AppModel', 'Model');
class DriverLocality extends AppModel {
    
    public $order = 'Driver.id';
    
    public $useTable = 'drivers_localities';
    
    public $belongsTo = array(
        'Driver' => array(
            'fields'=>array('id', 'username', 'max_people_count', 'travel_count', 'operator_id', 'email_active', 'mobile_app_active')
        )        
    );
}

?>