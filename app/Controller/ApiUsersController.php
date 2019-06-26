<?php

App::uses('ApiAppController', 'Controller');
App::import('Vendor', 'JWT', array('file' => 'firebase' . DS . 'php-jwt' . DS . 'src' . DS . 'JWT.php'));

class ApiUsersController extends ApiAppController {
    
    public $uses = array('Driver');
    
    public function beforeFilter() {
        $this->Auth->allow('token');
    }
    
    public function token() {
        /*$user = $this->Auth->identify($this->request, $this->response);
        if (!$user) {
            throw new UnauthorizedException('Invalid username or password');
        }*/
        
        //if(empty($this->request->data)) throw new UnauthorizedException('Invalid username or password');

        $this->set(array(
            'success' => true,
            'data' => /*$this->_getToken($this->request->data)*/'MARTIN',
            '_serialize' => array('success', 'data')
        ));
    }
    
    /**
     * @param string $userToken
     * @return string
     */
    private function _getToken($user) {
        $token = array(
            /*"iss" => "http://example.org",
            "aud" => "http://example.com",
            "iat" => 1356999524,
            "nbf" => 1357000000,*/
            "user" => array(
                'name' => $user['username'],
                'token' => $user['password'],
            )
        );
        
        return Firebase\JWT\JWT::encode($token, $this->Auth->settings['pepper']);
    }
    
}

?>