<?php
App::uses('AppController', 'Controller');
App::uses('StringsUtil', 'Util');

class TaxiAvailablePostsController extends AppController {
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('home','add');
    }
    
    public function add() {
        if($this->request->is('post')) {
            
            // Poner algunos datos extra
            $tokenId = StringsUtil::getWeirdString();
            $this->request->data['TaxiAvailablePost']['token_id'] = $tokenId;
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
            
            // Poner algunos datos extra
            $tokenId = StringsUtil::getWeirdString();
            $this->request->data['TaxiAvailablePost']['token_id'] = $tokenId;
            if($this->Auth->loggedIn()) $this->request->data['TaxiAvailablePost']['created_by'] = $this->Auth->user('role');
            
            // Some fixes
            if($this->request->data['TaxiAvailablePost']['time_available_end'] == -1)
                $this->request->data['TaxiAvailablePost']['time_available_end'] = null;
            
            if($this->TaxiAvailablePost->save($this->request->data)) {
                $this->setSuccessMessage('Nueva disponibilida de taxi agregada');
                return $this->redirect(array('action'=>'thanks', $tokenId));
            }
        }
        
        $this->layout = 'add_new_offer';
    }
    
    public function thanks($token) {
        
        $this->layout = 'add_new_offer';

    }
    
    public function home() {
        $today = date('Y-m-d', strtotime('today')); 
        $taxisAvailable = $this->TaxiAvailablePost->find('all',array('order'=>array('TaxiAvailablePost.date'=>'ASC', 'TaxiAvailablePost.origin_id', 'TaxiAvailablePost.destination_id'),'conditions'=>array('TaxiAvailablePost.date >='=>$today)));
        //formatting the final result by dates
        $taxisAvailableByDate = array();
        foreach ($taxisAvailable as $key => $value) {
            $currdate = $value['TaxiAvailablePost']['date'];
            $taxisAvailableByDate[$currdate][]=$value ;
        }
        
        $this->set('taxis_available', $taxisAvailableByDate);
        
        $this->layout = 'home';
        $this->render('marketplace-for-casas');
    }
}

?>