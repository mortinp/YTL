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

    public $uses = array('Travel', 'Locality', 'Driver', 'User', 'DriverLocality', 'Province', 'LocalityThesaurus', 'DiscountRide', 'Testimonial');

    public $components = array('TravelLogic', 'LocalityRouter', 'Paginator', 'Discount');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('home','add');
    }

    public function home() {
        $this->layout = 'home_cheap_taxi';
        
        // TODO: Cargar viajes disponibles aquí
        $this->DiscountRide->recursive = 3;
        $today = date('Y-m-d', strtotime('today')); 
        $discounts = $this->DiscountRide->find('all',array('order'=>array('DiscountRide.date'=>'ASC'),'conditions'=>array('DiscountRide.active'=>1,'DiscountRide.date >='=>$today)));
        //formatting the final result by dates
        $discount_rides_by_date = array();
        foreach ($discounts as $key => $value) {
            $currdate = $value['DiscountRide']['date'];            
            $discount_rides_by_date[$currdate][]=$value ;
        }
        
        $this->set('discount_rides_by_date', $discount_rides_by_date);
        
        // Algunos datos que hacen falta en la vista
        $this->set('stats', $this->_getVanityStats());
        $this->set('testimonials_sample', $this->Testimonial->getSample());
        
        $this->render('cheap-taxi-cuba');
    }


    public function index() {
        $this->DiscountRide->recursive = 3;        
        $this->paginate = array('order'=>array('DiscountRide.date'=>'ASC'),'limit'=>10);
        
        $discountRides = $this->paginate('DiscountRide');
        
        $this->set('discountRides', $discountRides);
    }

    public function add() {

        if ($this->request->is('post')|| $this->request->is('put')) {

                $this->request->data['DiscountRide']['date'] = TimeUtil::dateFormatBeforeSave($this->request->data['DiscountRide']['date']);
                $discountRide = $this->request->data;
                 
                 /* Hack para no tener que modificar el driver-typeahead */
                /*$driver = $this->_getDriverFromFormData($discountRide['DiscountRide']);
                 if(empty($discountRide['DiscountRide']['web_auth_token'])){
                     $driver = $this->Driver->findById($discountRide['DiscountRide']['driver_id']);
                     
                     $discountRide['DiscountRide']['web_auth_token'] = $driver['Driver']['web_auth_token'];
                 }*/
                 /* Fin Hack */
                $driver = $this->Driver->findById($discountRide['DiscountRide']['driver_id']);
                     
                if($this->Discount->add_discount_offer($driver, $discountRide)) {
                    $this->setSuccessMessage('El nuevo viaje con descuento ha sido creado');
                    
                    $userLoggedIn = AuthComponent::user('id') ? true : false; 
                    if($userLoggedIn) return $this->redirect(array('controller'=>'discount_rides', 'action' => 'index'));
                    else return $this->redirect($this->referer());
                } else {
                    $this->setErrorMessage('Ocurrió un problema guardando la información del viaje con descuento. Intenta de nuevo.');
                    return $this->redirect($this->referer());
                }
            }
            $this->set('drivers', $this->Driver->getAsSuggestions()); 
    }
    
    public function edit($tId) {        
        if ($this->request->is('post') || $this->request->is('put')) {           
                 
            $this->request->data['DiscountRide']['id'] = $tId;            
            $discountRide = $this->request->data;
        }

        $editing = $this->request->is('ajax') || $this->request->is('post') || $this->request->is('put');
        if($editing) {
            if($this->DiscountRide->save($discountRide)) {           
                    $this->setSuccessMessage('El viaje con descuento ha sido modificado');
                    return $this->redirect(array('action' => 'index'));
                }
                $this->setErrorMessage(__('Ocurrió un error actualizando este viaje con descuento. Intenta de nuevo.'));
            
        }
        
        $discountRide = $this->DiscountRide->findById($tId);
        if (!$this->request->data) {
            $this->request->data['DiscountRide'] = $discountRide['DiscountRide'];
        }
    }

}
