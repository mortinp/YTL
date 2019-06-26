<?php

App::uses('Controller', 'Controller');

class ApiAppController extends Controller {
    
    public $components = array(
        'RequestHandler',
        
        'Auth' => array(
            'authenticate' => array(
                'JwtAuth.JwtToken' => array(
                    'fields' => array(
                        'username' => 'username',
                        'password' => 'password',
                        'token' => 'password',
                    ),
                    'parameter' => '_token',
                    'userModel' => 'Driver',
                    'scope' => array('Driver.active' => 1),
                    'pepper' => 'xyzw',
                ),
            ),
        ),
        
    );
}