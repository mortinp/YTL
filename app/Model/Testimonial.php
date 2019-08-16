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
    
    public $hasMany = array('TestimonialsReply');
    
    public $actsAs = array('HardDiskSave' => array('hard_disk_save' => 'image', 'path_type' => 'relative'));
    
    public static $langs = array('es', 'en');
    public static $states = array('L' => 'all', 'P' => 'pending', 'A' => 'approved', 'R' => 'rejected');
    public static $statesValues = array('all' => 'L', 'pending' => 'P', 'approved' => 'A', 'rejected' => 'R');
    
    public function getSample($testimonialsCount = 3) {
        $this->recursive = 2;
        $this->Driver->unbindModel(array('hasAndBelongsToMany' => array('Locality')));

        $lang = array(Configure::read('Config.language'));
        $conditions = array('Testimonial.featured'=>true, /*'Testimonial.lang'=>$lang,*/ 'Testimonial.image_filepath IS NOT NULL', 'Testimonial.image_filepath !='=>'');

        $testimonials_sample = $this->find('all', array('conditions'=>$conditions, 'order'=>array('Testimonial.created'=>'DESC'), 'limit'=>$testimonialsCount));

        return $testimonials_sample;
    }
}

?>
