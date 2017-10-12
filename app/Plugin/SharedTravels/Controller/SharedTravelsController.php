<?php
App::uses('AppController', 'Controller');
App::uses('StringsUtil', 'Util');
App::uses('EmailsUtil', 'Util');
App::uses('SharedTravel', 'SharedTravels.Model');
App::uses('ExpiredLinkException', 'Error');

class SharedTravelsController extends AppController {
    
    public $uses = array('SharedTravels.SharedTravel', 'User');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('create', 'thanks', 'activate', 'view');
    }
    
    public function index() {
        $this->paginate = array('order'=>array('SharedTravel.id'=>'DESC'));
        $this->set('travels', $this->paginate());
    }
    
    public function home() {
    }
    
    public function create() {
        if ($this->request->is('post') || $this->request->is('put')) {            
            $this->SharedTravel->create();
            
            // Poner algunos datos extra
            $this->request->data['SharedTravel']['lang'] = Configure::read('Config.language');
            $this->request->data['SharedTravel']['state'] = SharedTravel::$STATE_PENDING;
            
            // Generar los token
            $idToken = StringsUtil::getWeirdString();
            $activationToken = StringsUtil::getWeirdString();
            $this->request->data['SharedTravel']['id_token'] = $idToken;
            $this->request->data['SharedTravel']['activation_token'] = $activationToken;
            
            // Salvar la solicitud
            $OK = $this->SharedTravel->save($this->request->data);
            
            // Verificar si el correo es de un usuario
            $user = $this->User->findByUsername($this->request->data['SharedTravel']['email']);
            $byUser = $user != null && !empty ($user);
            
            if($OK) {
                // Si ya era un usuario, activar todo
                if($byUser) {
                    return $this->redirect(array('action'=>'activate/'.$activationToken));
                } else {
                    // Obtener la solicitud para que los datos vengan formateados (ej. la fecha)
                    $request = $this->SharedTravel->findByIdToken($idToken);
                    $OK = EmailsUtil::email(
                        $request['SharedTravel']['email'], 
                        __d('shared_travels', 'Confirma tu solicitud de viaje compartido'),
                        array('request' => $request), 
                        'no_responder', 
                        'SharedTravels.email2user_activate_request',
                        array('lang'=>Configure::read('Config.language'), 'enqueue'=>false)
                    );
                }
            }
            
            
            if($OK) return $this->redirect(array('action' => 'thanks?t='.$idToken));
            
            $this->setErrorMessage(__('Ocurrió un error realizando la solicitud.'));
        }
        
        if(!isset ($this->request->query['s'])) throw new NotFoundException ();
        if(!array_key_exists($this->request->query['s'], SharedTravel::$modalities)) throw new NotFoundException();
    }
    
    public function thanks() {
        if(!isset ($this->request->query['t'])) throw new NotFoundException ();
        
        $request = $this->SharedTravel->findByIdToken($this->request->query['t']);
        if($request == null || empty ($request)) throw new NotFoundException();
        
        $this->set('request', $request);
    }
    
    public function activate($activationToken) {
        $request = $this->SharedTravel->findByActivationToken($activationToken);
        
        // Sanity checks
        if($request == null || empty ($request)) throw new NotFoundException();
        if($request['SharedTravel']['verified']) throw new ExpiredLinkException();
        
        if(!$this->doActivate($request)) throw new InternalErrorException();
        
        $this->set('request', $request);
    }
    
    private function doActivate($request) {
        $this->SharedTravel->id = $request['SharedTravel']['id'];
        $OK = $this->SharedTravel->saveField('verified', true);
        if($OK) $OK = $this->SharedTravel->saveField('state', SharedTravel::$STATE_ACTIVATED);
        
        if($OK) $OK = EmailsUtil::email(
            'martin@yotellevocuba.com', 
            'Solicitud de viaje compartido '.'[['.$request['SharedTravel']['id_token'].']]',
            array('request' => $request), 
            'shared_travel', 
            'SharedTravels.new_request'
        );
        
        return $OK;
    }
    
    public function view($token) {
        $request = $this->SharedTravel->findByIdToken($token);
        
        // Sanity checks
        if($request == null || empty ($request)) throw new NotFoundException();
        if(!$request['SharedTravel']['verified']) throw new NotFoundException();
        
        $this->set('request', $request);
    }
}

?>