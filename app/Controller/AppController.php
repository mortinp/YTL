<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    
    /*private $pageTitles = array(
        'pages.display' =>array(
            'contact'=>'Contactar', 
            'use_terms'=>'Términos de Uso', 
            'tour'=>'¿Cómo usarlo?',
            'faq'=>'Preguntas Frecuentes',
            'by_email'=>'Consigue un taxi usando tu correo electrónico'),
        
        'users.index' =>'Usuarios',
        'users.add' =>'Crear Nuevo Usuario',
        
        'users.login' =>'Entra y encuentra un taxi enseguida',
        'users.register' =>'Regístrate y encuentra un taxi enseguida',
        'users.profile' =>'Preferencias',
        
        'users.change_password' =>'Cambiar Contraseña',
        'users.confirm_email' =>'Confirmación de Correo',
        'users.forgot_password' =>'Contraseña Olvidada',
        'users.send_change_password' =>'Instrucciones para Cambio de Contraseña',
        'users.send_confirm_email' =>'Instrucciones para Verificación de Correo',
        
        'drivers.index' =>'Choferes',
        'drivers.add' =>'Crear Nuevo Chofer',
        
        'travels.index' =>'Anuncios de Viajes',
        'travels.add' =>'Crear Anuncio de Viaje',
        'travels.view' =>'Ver Anuncio de Viaje',
        'travels.add_pending' =>'Crear Anuncio de Viaje',
    );*/
    
    public $helpers = array(
        'Html' => array(
            'className' => 'EnhancedHtml'
        ), 
        'Form' => array(
            'className' => 'BootstrapForm'
        ),
        'Session', 
        'Js');
    
    public $components = array(
        'Session',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'travels', 'action' => 'index'),
            'logoutRedirect' => '/',
            'authorize' => array('Controller'),
            'authError' => '<div class="alert alert-danger alert-dismissable" style="text-align: center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>No tienes permisos para realizar esa acción o visitar esa página.</div>'
        ),
        'Cookie'
    );

    public function beforeFilter() {
        // Cookie login
        $this->Auth->authenticate = array(
            'Cookie' => array(
                'fields' => array(
                    'username' => 'username',
                    'password' => 'password'
                ),
                'userModel' => 'User',
            ),
            'Form'
        );        
        
        // Allow all static pages
        $this->Auth->allow('display');
        
        Configure::write('Config.language', 'es');
        
        $this->setPageTitle();
    }
    
    private function setPageTitle() {
        $page_title = __('Consigue un taxi para ir a cualquier parte de la isla');
        $page_description = __('Consigue un taxi para moverte dentro de Cuba. Acuerda los detalles del viaje directamente con tu chofer y arma tu presupuesto de transporte antes de llegar a la isla.');
        $key = $this->request->params['controller'].'.'.$this->request->params['action'];        
        
        $partialTitle = $this->_getPageTitle($key);
        if($partialTitle != null) {
            if($this->request->params['controller'] === 'pages') {
                if(isset($partialTitle[$this->request->params['pass'][0]])) {
                    $page_title = $partialTitle[$this->request->params['pass'][0]]['title'];
                    if(isset ($partialTitle[$this->request->params['pass'][0]]['description'])) $page_description = $partialTitle[$this->request->params['pass'][0]]['description'];
                }
                    
            } else {
                $page_title = $partialTitle['title'];
                if(isset ($partialTitle['description'])) $page_description = $partialTitle['description'];
            }
        }
        $this->set('page_title', $page_title);
        $this->set('page_description', $page_description);
    }

    public function isAuthorized($user) {
        // Admin can access every action
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }
        // Default deny
        return false;
    }

    public function index() {
        
    }
    
    
    protected function setErrorMessage($message) {
        $this->Session->setFlash($message, 'error_message');
    }
    
    protected function setInfoMessage($message) {
        $this->Session->setFlash($message, 'info_message');
    }
    
    protected function setWarningMessage($message) {
        $this->Session->setFlash($message, 'warning_message');
    }
    
    protected function setSuccessMessage($message) {
        $this->Session->setFlash($message, 'success_message');
    }
    
    
    private function _getPageTitle($key) {
        $pageTitles = array(
            'pages.display' =>array(
                'contact'=>array('title'=>__('Contactar'), 'description'=>__('Contáctanos para cualquier pregunta o duda sobre cómo conseguir un taxi para moverte por Cuba usando YoTeLlevo.')), 
                'use_terms'=>array('title'=>__('Términos de Uso')), 
                'tour'=>array('title'=>__('¿Cómo usarlo?')),
                'faq'=>array('title'=>__('Preguntas Frecuentes'), 'description'=>__('Preguntas y respuestas sobre cómo conseguir un taxi para moverte por Cuba usando YoTeLlevo.')),
                'by_email'=>array('title'=>__('Consigue un taxi usando tu correo electrónico'))),

            'users.index' =>array('title'=>__('Usuarios')),
            'users.add' =>array('title'=>__('Crear Nuevo Usuario')),

            'users.login' =>array('title'=>__('Entra y encuentra un taxi enseguida')),
            'users.register' =>array('title'=>__('Regístrate y encuentra un taxi enseguida')),
            'users.profile' =>array('title'=>__('Preferencias')),

            'users.change_password' =>array('title'=>__('Cambiar Contraseña')),
            'users.confirm_email' =>array('title'=>__('Confirmación de Correo')),
            'users.forgot_password' =>array('title'=>__('Contraseña Olvidada')),
            'users.send_change_password' =>array('title'=>__('Instrucciones para Cambio de Contraseña')),
            'users.send_confirm_email' =>array('title'=>__('Instrucciones para Verificación de Correo')),

            'drivers.index' =>array('title'=>__('Choferes')),
            'drivers.add' =>array('title'=>__('Crear Nuevo Chofer')),

            'travels.index' =>array('title'=>__('Anuncios de Viajes')),
            'travels.add' =>array('title'=>__('Crear Anuncio de Viaje')),
            'travels.view' =>array('title'=>__('Ver Anuncio de Viaje')),
            'travels.add_pending' =>array('title'=>__('Crear Anuncio de Viaje')),
        );
        
        if(isset ($pageTitles[$key])) return $pageTitles[$key];
        
        return null;
    }
}
