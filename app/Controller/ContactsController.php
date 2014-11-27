<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class ContactsController extends AppController {
    
    public function beforeFilter() {
        parent::beforeFilter();
        
        $this->Auth->allow('contact');
    }
    
    public function isAuthorized($user) {
        if (in_array($this->action, array('contact'))) {
            return true;
        }

        return parent::isAuthorized($user);
    }

    public function contact() {
        if ($this->request->is('post')) { 
            
            $OK = true;
            
            if($this->Auth->loggedIn()) $this->request->data['Contact']['email'] = AuthComponent::user('username');
            
            $to = /*'mproenza@grm.desoft.cu'*/'soporte@'.Configure::read('domain_name');
            /*if(class_exists('EmailConfig')) {
                $configs = new EmailConfig();
                if (isset($configs->soporte)) {
                    if(is_array($configs->soporte['from'])) {
                        $keys = array_keys($configs->soporte['from']);
                        $to = $keys[0];
                    } else $to = $configs->soporte['from'];
                }
            }
            echo $to;*/
                        
            $Email = new CakeEmail('contacto');
            $Email->template('contact')
            ->viewVars(array('contact'=>$this->request->data))
            ->emailFormat('html')
            ->to($to)
            ->subject('Nuevo Contacto');
            try {
                $Email->send();
            } catch ( Exception $e ) {
                $this->setErrorMessage('Ocurrió un error recibiendo tu mensaje. Intenta de nuevo.');
                $OK = false;
            }
            
            if($OK) $this->setInfoMessage('Ya recibimos tu mensaje.');
            
            return $this->redirect(array('controller'=>'pages', 'action'=>'contact'));
        }
    }
}

?>