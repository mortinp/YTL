<?php
App::uses('ApiAppController', 'Controller');

App::import('Vendor', 'JWT', array('file' => 'firebase' . DS . 'php-jwt' . DS . 'src' . DS . 'JWT.php'));
App::import('Vendor', 'SignatureInvalidException', array('file' => 'firebase' . DS . 'php-jwt' . DS . 'src' . DS . 'SignatureInvalidException.php'));
//App::import('Vendor', 'JWT', array('file' => 'firebase' . DS . 'php-jwt' . DS . 'src' . DS . 'JWT.php'));
//App::import('Vendor', 'JWT', array('file' => 'firebase' . DS . 'php-jwt' . DS . 'src' . DS . 'JWT.php'));

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
        $token = $this->_generateToken($this->request->data('username'), $this->request->data('password'));
        
        // Simular una request para identificarse (esta es la forma mas facil)
        $dummyRequest = new CakeRequest('aaa/bbb?_token=' . $token);
        
        // Identificar el usuario con la request simulada
        $user = $this->TokenAuth->getUser($dummyRequest);
        
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