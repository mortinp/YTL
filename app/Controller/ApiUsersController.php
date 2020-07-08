<?php
App::uses('ApiAppController', 'Controller');
App::uses('PathUtil', 'Util');

class ApiUsersController extends ApiAppController {
    
    //public $uses = array('Driver');
    
    public function beforeFilter() {
        parent::beforeFilter();
        
        $this->Auth->allow('token', 'token_v2');
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
    public function token_v2() {        
        // Generar token para el usuario y contrasenna que llegan
        $token = $this->_generateToken(
                $this->request->data('username'), 
                AuthComponent::password($this->request->data('password'))
        );
        
        // Identificar el usuario
        $user = $this->TokenAuth->_findUser($token);
        
        if(!$user) throw new UnauthorizedException('Invalid username or password');
        
        $driver = array(
            'id' => $user['id'],
            'email' => $user['username'],
            'name' => $user['DriverProfile']['driver_name'],
            'avatar_url' => PathUtil::getFullPath($user['DriverProfile']['avatar_filepath']),
            
            'token' => $token,
        );

        //debug($this->request->data);
        $this->set(array(
            'success' => true,
            'data' => $driver,
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