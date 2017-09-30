<?php
App::uses('AppModel', 'Model');
App::uses('Testimonial', 'Model');
?>
<?php

class DriverTransactionalEmail extends AppModel {
    
    public static $TYPE_REMINDER_OLD_TESTIMONIALS = 1;
    public static $TYPE_REMINDER_STILL_NO_TESTIMONIALS = 2;
    
    public $useTable = 'drivers_transactional_emails';
    
    public $belongsTo = array(
        'Driver' => array(
            'fields'=>array('id', 'username')
        )
    );
}

?>