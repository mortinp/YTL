<?php

App::uses('AppController', 'Controller');
App::uses('Activity', 'Activities.Model');

class ActivitiesController extends AppController {
    
     public $uses = array('Driver', 'Activities.Activity', 'User','ActivityDriverSubscription' );
     
     public function index() {       
       $activities = array();  
       $this->ActivityDriverSubscription->recursive=3;
         foreach (Activity::$activities as $key=>$element) {
            $subscription = $this->ActivityDriverSubscription->find('all',array('conditions'=>array('activity_id'=>$key)));
            $subscriptions=array();
            if (count($subscription)>0){               
                
                foreach ($subscription as $value) {
                   $subscriptions[]=$value; 
                }
                
            }
            
            $activities[$key] = array('Activity'=>$element,'Subscriptions'=>$subscriptions);
         }
        
        
        $this->set('activities', $activities);
     }
    
    public function display($activitySlug) {        
        $activity = null;
        foreach (Activity::$activities as $key=>$a) {
            if($a['slug'] == $activitySlug) {                
                $subscription = $this->ActivityDriverSubscription->find('all',array('conditions'=>array('activity_id'=>$key)));
                if (count($subscription) > 0){                
                    $a['Subscriptions'] = $subscription;
                }
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
    
     public function remove_driver($id = null) {
        $this->ActivityDriverSubscription->id = $id;
        if (!$this->ActivityDriverSubscription->exists()) {
            throw new NotFoundException('Invalid subscription');
        }
        if ($this->ActivityDriverSubscription->delete()) {
            $this->setInfoMessage('El chofer se eliminó exitosamente.');
        } else {
            $this->setErrorMessage('Ocurrió un error eliminando el chofer');
        }
        
        return $this->redirect(array('action' => 'index'));
    }
}

?>