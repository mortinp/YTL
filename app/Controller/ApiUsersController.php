<?php

App::uses('ApiAppController', 'Controller');

class ApiUsersController extends ApiAppController {
    
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