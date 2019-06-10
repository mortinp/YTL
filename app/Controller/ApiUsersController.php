<?php

App::uses('AppController', 'Controller');

class ApiUsersController extends AppController {
    public $components = array('RequestHandler');
    
    public function beforeFilter() {
        $this->Auth->allow('token');
    }
    
    public function token() {
        /*$user = $this->Auth->identify();
        if (!$user) {
            throw new UnauthorizedException('Invalid username or password');
        }*/

        $this->set(array(
            'success' => true,
            'data' => 'MARTIN',
            '_serialize' => array('success', 'data')
        ));
    }
    
}

?>