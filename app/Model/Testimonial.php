<?php

App::uses('AppModel', 'Model');

class Testimonial extends AppModel {
    
    public $order = 'Testimonial.created DESC';

    public $validate = array(
        'text' => array('rule' => 'notEmpty'),
        'author' => array('rule' => 'notEmpty'),
        'email' => array('rule' => 'email', 'message' => 'Escribe una dirección de correo válida')
    );
    
    public $belongsTo = array('Driver');
    
    public $actsAs = array('HardDiskSave' => array('hard_disk_save' => 'image', 'path_type' => 'relative'));
    
    public static $langs = array('es', 'en');
    public static $states = array('L' => 'all', 'P' => 'pending', 'A' => 'approved', 'R' => 'rejected');
    public static $statesValues = array('all' => 'L', 'pending' => 'P', 'approved' => 'A', 'rejected' => 'R');
}

?>
