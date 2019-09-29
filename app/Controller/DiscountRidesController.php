<?php
App::uses('AppController', 'Controller');
App::uses('User', 'Model');
App::uses('Travel', 'Model');
App::uses('Driver', 'Model');
App::uses('DiscountRide', 'Model');
App::uses('TimeUtil', 'Util');
/**
 * DiscountRides Controller
 *
 */
class DiscountRidesController extends AppController {

public $uses = array('Travel', 'Locality', 'Driver', 'User', 'DriverLocality', 'Province', 'LocalityThesaurus','DiscountRide');
    
public $components = array('TravelLogic', 'LocalityRouter', 'Paginator');

 public function beforeFilter() {
        parent::beforeFilter();
        if(!$this->Auth->loggedIn()) $this->Auth->allow('index');
 }

public function index() {
        $this->DiscountRide->recursive = 3;        
        $this->paginate = array('order'=>array('DiscountRide.date'=>'ASC'),'limit'=>10);
        $conditions = array();
        $discountRides = $this->paginate('DiscountRide');
        
        $this->set('discountRides', $discountRides);      
       
}
    
public function add(){
    
    if ($this->request->is('post')|| $this->request->is('put')) {           
            
            $this->request->data['DiscountRide']['date'] = TimeUtil::dateFormatBeforeSave($this->request->data['DiscountRide']['date']);
             $discountRide = $this->request->data; 
            if($this->DiscountRide->save($discountRide)) {      
                $this->setSuccessMessage('El nuevo viaje con descuento ha sido creado');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->setErrorMessage('Ocurrió un problema guardando la información del viaje. Intenta de nuevo.');
            }
        }
        $this->set('drivers', $this->Driver->getAsSuggestions()); 
}

    

}
