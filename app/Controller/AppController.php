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
            
            // Este mensaje de error hay que tenerlo traducido en default.po, porque la traducción la usa el AuthComponent -le hice una modificacion al AuthComponent de CakePHP para esto
            'authError' => '<div class="alert alert-danger alert-dismissable" style="text-align: center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>No tienes permisos para visitar esa página.</div>'
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
        $this->Auth->allow('display', 'setlang');
        
        // Permitir una acción cuando se haya decidido que se permita (ej. las invitaciones deben permitir acceder a una url prohibida por defecto)
        if($this->Session->read('allowed_action') != null)
            $this->Auth->allow($this->Session->read('allowed_action'));
        
        $this->_setupLanguage();
        $this->_setPageTitle();
        $this->_setUserCredentials();
    }
    
    private function _setupLanguage() {
        $lang = $this->Session->read('next.page.lang');
        if($lang == null) $lang = $this->Cookie->read('app.lang');
        if($lang == null) $lang = Configure::read('Config.language')/*Configure::read('default_language')*/;
        
        $this->Session->write('app.lang', $lang);
        Configure::write('Config.language', $this->Session->read('app.lang'));
    }
    
    public function afterFilter() {
        $this->Session->write('next.page.lang', null);
    }
    
    private function _setPageTitle() {
        $defaultTitle = $this->_getPageTitle('default');        
        $page_title = $defaultTitle['title'];
        $page_description = $defaultTitle['description'];
        
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
    
    public function _setUserCredentials() {
        // INITIALIZE
        $userLoggedIn = AuthComponent::user('id') ? true : false;
        $this->set('userLoggedIn', $userLoggedIn);
        
        if($userLoggedIn) {
            $user = AuthComponent::user();
            $userRole = $user['role'];
            $this->set('userRole', $userRole);
        }        
    }

    public function isAuthorized($user) {
        // admin can access every action
        if (isset($user['role']) && ($user['role'] === 'admin' || $user['role'] === 'operator')) return true;
        
        return false;
    }

    public function index() {
        
    }    
    
    private function _getPageTitle($key) {
        $pageTitles = array(
            'default' =>array('title'=>'Cuba | '.__d('meta', 'Contrata un chofer con auto para tus viajes: La Habana, Varadero, Viñales, Trinidad, Santiago de Cuba y más'), 'description'=>__d('meta', 'Consigue un taxi para moverte dentro de Cuba. Acuerda los detalles del viaje directamente con tu chofer y arma tu presupuesto de transporte antes de llegar a la isla.')),
            
            // Unrestricted access
            'pages.display' =>array(
                'contact'=>array('title'=>__d('meta', 'Contactar'), 'description'=>__d('meta', 'Contáctanos para cualquier pregunta o duda sobre cómo conseguir un taxi para moverte por Cuba usando YoTeLlevo')), 
                'faq'=>array('title'=>__d('meta', 'Preguntas Frecuentes'), 'description'=>__d('meta', 'Preguntas y respuestas sobre cómo conseguir un taxi para moverte por Cuba usando YoTeLlevo')),
                'testimonials'=>array('title'=>__d('meta', 'Testimonios de viajeros sorprendentes en Cuba'), 'description'=>__d('meta', 'Testimonios de viajeros que contrataron choferes con YoTeLlevo, Cuba'))),

            'users.login' =>array('title'=>__d('meta', 'Entrar'), 'description'=>__d('meta', 'Entra y consigue un taxi enseguida. Acuerda los detalles del viaje con tu chofer directamente')),
            'users.register' =>array('title'=>__d('meta', 'Registrarse'), 'description'=>__d('meta', 'Regístrate y consigue un taxi enseguida. Acuerda los detalles del viaje con tu chofer directamente')),
            
            'travels.add_pending' =>array('title'=>__d('meta', 'Crear Anuncio de Viaje')/*, 'description'=>__d('meta', 'Crea un Anuncio de Viaje y consigue un taxi enseguida. Acuerda los detalles del viaje con tu chofer directamente')*/),
            
            'testimonials.enter_code' =>array('title'=>__d('meta', 'Deja una opinión sobre tu chofer en Cuba'), 'description'=>__d('meta', 'Opinar y reseñar sobre tu viaje en auto con chofer en Cuba')),
            'testimonials.add' =>array('title'=>__d('meta', 'Opina sobre este chofer')),
            'testimonials.preview' =>array('title'=>__d('meta', 'Gracias por tu opinión')),
                
            
            // Users access
            'users.profile' =>array('title'=>__d('meta', 'Preferencias')),
            
            'users.change_password' =>array('title'=>__d('meta', 'Cambiar Contraseña')),
            'users.confirm_email' =>array('title'=>__d('meta', 'Confirmación de Correo')),
            'users.forgot_password' =>array('title'=>__d('meta', 'Contraseña Olvidada')),
            'users.send_change_password' =>array('title'=>__d('meta', 'Instrucciones para Cambio de Contraseña')),
            'users.send_confirm_email' =>array('title'=>__d('meta', 'Instrucciones para Verificación de Correo')),
            
            'travels.index' =>array('title'=>__d('meta', 'Anuncios de Viajes')),
            'travels.add' =>array('title'=>__d('meta', 'Crear Anuncio de Viaje')),
            'travels.view' =>array('title'=>__d('meta', 'Ver Anuncio de Viaje')),
            
            'drivers.profile' =>array('title'=>__d('meta', 'Fotos del chofer %s y su auto')),
            
            'casas.add_request' =>array('title'=>__d('meta', 'Consigue casas particulares en Cuba con la ayuda de un experto')),            
            
            // Admin access
            'users.index' =>array('title'=>'Usuarios'),
            'users.add' =>array('title'=>'Nuevo usuario'),           
            'users.edit' =>array('title'=>'Editar usuario'),  
            'users.view_travels' =>array('title'=>'Viajes de usuario'),

            'drivers.index' =>array('title'=>'Choferes'),
            'drivers.add' =>array('title'=>'Nuevo chofer'),
            'drivers.edit_profile' =>array('title'=>'Editar perfil de chofer'),
            
            'driver_travels.view_filtered' => array('title'=>'Conversaciones'),
            'travels.view_filtered' =>array('title'=>'Solicitudes'),
            'driver_traveler_conversations.view' =>array('title'=>'Mensajes en conversación'),
            
            'metrics.dashboard' =>array('title'=>'Dashboard'),
            
            'url_invitations.index' =>array('title'=>'URLs compartidas'),
            'url_invitations.add' =>array('title'=>'Compartir URL'),
            
            'email_queues.index' =>array('title'=>'Email Queue'),
            
            'travels.admin' =>array('title'=>'Administrar Viaje'),
            
            'testimonials.view_filtered' =>array('title'=>'Testimonios'),
            'testimonials.admin' =>array('title'=>'Administrar Testimonio'),
            
        );
        
        if(isset ($pageTitles[$key])) return $pageTitles[$key];
        
        return null;
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
}