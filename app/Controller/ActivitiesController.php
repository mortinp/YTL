<?php

App::uses('AppController', 'Controller');
App::uses('Activity', 'Model');

class ActivitiesController extends AppController {
    
     public $uses = array('Driver', 'Activity', 'User','ActivityDriverSubscription' );
     
     public function index() {
       $activities = array();  
         foreach (Activity::$activities as $element) {
            $activities[] = $element;
         }      
        
        $this->set('activities', $activities);
                  
     }
    
    public function display($activitySlug) {        
        $activity = null;
        foreach (Activity::$activities as $a) {
            if($a['slug'] == $activitySlug) {
                $activity = $a;
                break;
            }
        }
        
        if($activity == null) throw new NotFoundException();
        
        $this->set(compact('activity'));
        
        $this->layout = 'activity';
        $this->render($activity['display_page']);
    }
    
    public function add_drivers($activity) {  
        
         if ($this->request->is('post') || $this->request->is('put')) { 
             //die(print_r($this->request->data));
               if($this->ActivityDriverSubscription->save($this->request->data)) {           
                    $this->setSuccessMessage('Se ha agregado el chofer a esta actividad correctamente');
                    return $this->redirect(array('action' => 'index'));
                }
                $this->setErrorMessage(__('Ocurrió un error asignando un chofer a esta actividad. Intente nuevamente.'));
              
          
        }
      
         $this->set('drivers', $this->Driver->getAsSuggestions()); 
        $this->set('activity', $activity);
        
        
    }
}

?>