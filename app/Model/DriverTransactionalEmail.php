<?php
App::uses('AppModel', 'Model');
App::uses('Testimonial', 'Model');
?>
<?php

class DriverTransactionalEmail extends AppModel {
    
    public static $TYPE_REMINDER_TESTIMONIALS = 1;
    
    public $useTable = 'drivers_transactional_emails';
}

?>