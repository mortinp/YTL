<?php
App::uses('AppController', 'Controller');

class TaxiAvailablePostsController extends AppController {
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('home','add');
    }
    
    public function add() {
        if($this->request->is('post')) {
            
            if($this->Auth->loggedIn()) $this->request->data['TaxiAvailablePost']['created_by'] = $this->Auth->user('role');
            
            // Some fixes
            if($this->request->data['TaxiAvailablePost']['time_available_end'] == -1)
                $this->request->data['TaxiAvailablePost']['time_available_end'] = null;
            
            if($this->TaxiAvailablePost->save($this->request->data)) {
                $this->setSuccessMessage('Nueva disponibilida de taxi agregada');
                return $this->redirect(array('action'=>'add'));
            }
        }
    }
    
    public function add_new_offer() {
        if($this->request->is('post')) {
            
            if($this->Auth->loggedIn()) $this->request->data['TaxiAvailablePost']['created_by'] = $this->Auth->user('role');
            
            // Some fixes
            if($this->request->data['TaxiAvailablePost']['time_available_end'] == -1)
                $this->request->data['TaxiAvailablePost']['time_available_end'] = null;
            
            if($this->TaxiAvailablePost->save($this->request->data)) {
                $this->setSuccessMessage('Nueva disponibilida de taxi agregada');
                return $this->redirect(array('action'=>'gracias'));
            }
        }
        
        $this->layout = 'marketplace';
    }
    
    public function home() {
        $this->layout = 'marketplace';
        
        $today = date('Y-m-d', strtotime('today')); 
        $taxisAvailable = $this->TaxiAvailablePost->find('all',array('order'=>array('TaxiAvailablePost.date'=>'ASC', 'TaxiAvailablePost.origin_id', 'TaxiAvailablePost.destination_id'),'conditions'=>array('TaxiAvailablePost.date >='=>$today)));
        //formatting the final result by dates
        $taxisAvailableByDate = array();
        foreach ($taxisAvailable as $key => $value) {
            $currdate = $value['TaxiAvailablePost']['date'];
            $taxisAvailableByDate[$currdate][]=$value ;
        }
        
        $this->set('taxis_available', $taxisAvailableByDate);
        
        /*// Algunos datos que hacen falta en la vista
        $this->set('stats', $this->_getVanityStats());
        $this->set('testimonials_sample', $this->Testimonial->getSample());*/
        
        $this->render('marketplace-for-casas');
    }
}

?>