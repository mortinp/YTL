<?php
App::uses('AppModel', 'Model');

class TestimonialsReply extends AppModel {
    
    public $order = 'TestimonialsReply.created DESC';
        
    public $belongsTo = array('Testimonial');
        
    public static $langs = array('es', 'en');
    public static $states = array('L' => 'all', 'P' => 'pending', 'A' => 'approved', 'R' => 'rejected');
    public static $statesValues = array('all' => 'L', 'pending' => 'P', 'approved' => 'A', 'rejected' => 'R');


}
