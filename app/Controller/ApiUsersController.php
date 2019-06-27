<?php
App::uses('ApiAppController', 'Controller');

class ApiUsersController extends ApiAppController {
    
    //public $uses = array('Driver');
    
    public function beforeFilter() {
        parent::beforeFilter();
        
        $this->Auth->allow('token');
    }
    
    public function token() {
        /*$user = $this->Auth->identify($this->request, $this->response);
        if (!$user) {
            throw new UnauthorizedException('Invalid username or password');
        }*/
        
        //if(empty($this->request->data)) throw new UnauthorizedException('Invalid username or password');
        
        // Generar token para el usuario y contrasenna que llegan
        $token = $this->_generateToken(
                $this->request->data('username'), 
                AuthComponent::password($this->request->data('password'))
        );
        
        // Identificar el usuario
        $user = $this->TokenAuth->_findUser($token);
        
        if(!$user) throw new UnauthorizedException('Invalid username or password');

        //debug($this->request->data);
        $this->set(array(
            'success' => true,
            'data' => $token,
            '_serialize' => array('success', 'data')
        ));
    }
    
    /**
     * @param string $userToken
     * @return string
     */
    private function _generateToken($username, $password) {
        $token = array(
            /*"iss" => "http://example.org",
            "aud" => "http://example.com",
            "iat" => 1356999524,
            "nbf" => 1357000000,*/
            "user" => array(
                'name' => $username,
                'token' => $password,
            )
        );
        
        return Firebase\JWT\JWT::encode($token, $this->TokenAuth->settings['pepper']);
    }
    
}

?>