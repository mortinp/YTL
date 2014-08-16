<?php
App::uses('AppModel', 'Model');
class DriverTravelerConversation extends AppModel {
    
    public $order = 'id';
    
    /*public $order = 'DriverTravelerConversation.id';

    public $belongsTo = array(
        'DriverTravel' => array(
            'foreignKey'=>'conversation_id'
        )
    );*/
}

?>