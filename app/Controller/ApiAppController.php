<?php
App::uses('Controller', 'Controller');
App::uses('JwtTokenAuthenticate', 'JwtAuth.Controller/Component/Auth');

App::import('Vendor', 'JWT', array('file' => 'firebase' . DS . 'php-jwt' . DS . 'src' . DS . 'JWT.php'));
App::import('Vendor', 'SignatureInvalidException', array('file' => 'firebase' . DS . 'php-jwt' . DS . 'src' . DS . 'SignatureInvalidException.php'));
//App::import('Vendor', 'JWT', array('file' => 'firebase' . DS . 'php-jwt' . DS . 'src' . DS . 'JWT.php'));
//App::import('Vendor', 'JWT', array('file' => 'firebase' . DS . 'php-jwt' . DS . 'src' . DS . 'JWT.php'));

class ApiAppController extends Controller {
    
    public $components = array(
        'RequestHandler',
        
        'Auth'/* => array(
            'authenticate' => array(
                'JwtAuth.JwtToken' => array(
                    'fields' => array(
                        'username' => 'username',
                        //'password' => 'password',
                        'token' => 'password',
                    ),
                    'parameter' => '_token',
                    'userModel' => 'Driver',
                    'scope' => array('Driver.active' => 1),
                    'pepper' => 'xyzw',
                ),
            ),
        ),*/
        
    );
    
    public function beforeFilter() {
        $Collection = new ComponentCollection();
        $this->TokenAuth = new JwtTokenAuthenticate($Collection, array(
                'fields' => array(
                    'username' => 'username',
                    'token' => 'password',
                ),
                'parameter' => '_token',
                'userModel' => 'Driver',
                'scope' => array('Driver.active' => 1),
                'pepper' => 'xyzw',
        ));
        //$this->Auth = $this->TokenAuth;
    }
    
    protected function getUser() {
        $user = $this->TokenAuth->getUser($this->request);
        
        if(!$user) throw new UnauthorizedException('No se pudo identificar el usuario');
        
        return $user;
    }
}