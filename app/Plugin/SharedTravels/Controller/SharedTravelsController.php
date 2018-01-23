<?php
App::uses('AppController', 'Controller');
App::uses('StringsUtil', 'Util');
App::uses('EmailsUtil', 'Util');
App::uses('SharedTravel', 'SharedTravels.Model');
App::uses('ExpiredLinkException', 'Error');

class SharedTravelsController extends AppController {
    
    public $uses = array('SharedTravels.SharedTravel', 'User');
    
    public $layout = 'shared_rides';
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('create', 'thanks', 'activate', 'view', 'home');
    }
    
    public function index() {
        $this->paginate = array('order'=>array('SharedTravel.date'=>'ASC', 'SharedTravel.id'=>'ASC'), 'limit'=>50);
        $this->set('travels', $this->paginate(array('SharedTravel.email !=' => 'martin@yotellevocuba.com')));
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
            
            if($OK) {
                
                /*// Ver si se debe enviar el correo de verificacion
                $user = $this->User->findByUsername($this->request->data['SharedTravel']['email']);
                $byUser = $user != null && !empty ($user) && $user['User']['email_confirmed'];
                // TODO: Ver si este correo tiene otras solicitudes ya verificadas*/
                $mustVerify = true/*!$byUser*/; // TODO: Por ahora vamos siempre a enviar un correo de activacion de la solicitud
                
                if($mustVerify) {
                    // Obtener la solicitud para que los datos vengan formateados (ej. la fecha)
                    $request = $this->SharedTravel->findByIdToken($idToken);
                    $OK = EmailsUtil::email(
                        $request['SharedTravel']['email'], 
                        __d('shared_travels', 'Confirma tu solicitud de viaje compartido'),
                        array('request' => $request), 
                        'no_responder', 
                        'SharedTravels.activate_request',
                        array('lang'=>Configure::read('Config.language'), 'enqueue'=>false)
                    );
                } else {
                    return $this->redirect(array('action'=>'activate/'.$activationToken));
                }
            }
            
            
            if($OK) return $this->redirect(array('action' => 'thanks?t='.$idToken));
            
            $this->setErrorMessage(__('Ocurrió un error realizando la solicitud.'));
        }
        
        //
        if(!isset ($this->request->query['s'])) throw new NotFoundException ();
        if(!array_key_exists($this->request->query['s'], SharedTravel::$modalities)) throw new NotFoundException();
    }
    
    public function thanks() { // Esta es una action que no hace ningun procesamiento, solamente es una thank you page
        if(!isset ($this->request->query['t'])) throw new NotFoundException ();
        
        $request = $this->SharedTravel->findByIdToken($this->request->query['t']);
        if($request == null || empty ($request)) throw new NotFoundException();
        
        $this->set('request', $request);
    }
    
    public function activate($activationToken) {
        $request = $this->SharedTravel->findByActivationToken($activationToken);
        
        // Sanity checks
        if($request == null || empty ($request)) throw new NotFoundException();
        if($request['SharedTravel']['activated']) throw new ExpiredLinkException();
        // TODO: Verificar que la solicitud no este expirada
        
        $datasource = $this->SharedTravel->getDataSource();
        $datasource->begin();
        
        $result = $this->doActivate($request); // Aqui es donde se hace todo el procesamiento!!!
        $OK = $result['success'];
        
        if($OK) {
            $datasource->commit();
            $this->set('request', $request);
            
            // Si se confirmo el viaje (ej. se emparejo con otro solicitud), mostrar otra vista
            if($result['confirmed']) {
                $this->set('confirmed_reason', $result['confirmed_reason']);
                $this->render('activate_confirmed');
            }
        } else {
            $datasource->rollback();
            throw new InternalErrorException();
        }
    }
    
    private function doActivate($request) {
        $this->SharedTravel->id = $request['SharedTravel']['id'];
        $OK = $this->SharedTravel->saveField('activated', true);
        if($OK) $OK = $this->SharedTravel->saveField('state', SharedTravel::$STATE_ACTIVATED);
        
        $confirmed = false;
        $confirmedReason = null;
        $coupled = null; // default: no hay emparejamientos       
        if($OK) {
            
            // Si la solicitud es de 4 personas, confirmarla directamente
            if($request['SharedTravel']['people_count'] == 4) {
                $this->SharedTravel->create();
                $OK = $this->SharedTravel->confirmRequest($request);
                
                // Correo a facilitador con el viaje completo
                $facilitator = Configure::read('shared_rides_facilitator');
                if($OK) $OK = EmailsUtil::email(
                    $facilitator['email'],
                    'Viaje de 4 pax completo',
                    array('request' => $request ), 
                    'shared_travel', 
                    'SharedTravels.new_full_ride'
                );
                
                $confirmed = true;
                $confirmedReason = __d('shared_travels', 'llena uno de nuestros autos de 4 plazas');
                
            } else {
                // Intentar emparejar con otras solicitudes
                $couplings = $this->findCouplings($request);
                if($couplings != null) { // Se encontro coupling!
                    $coupled = array_merge ($couplings, array($request));

                    // Crear un nuevo id para el emparejamiento
                    $couplingId = $this->SharedTravel->query ('select coalesce(max(coupling_id) + 1, 1) as new_id from shared_travels');

                    // Crear emparejamientos y confirmar todas las solicitudes emparejadas
                    foreach ($coupled as $c) {
                        $this->SharedTravel->create();

                        $this->SharedTravel->id = $c['SharedTravel']['id'];
                        $OK = $this->SharedTravel->saveField('coupling_id', $couplingId[0][0]['new_id']);

                        if($OK) $OK = $this->SharedTravel->confirmRequest($c);

                        if(!$OK) break;
                    }

                    // Correo a facilitador con el viaje completo
                    $facilitator = Configure::read('shared_rides_facilitator');
                    if($OK) $OK = EmailsUtil::email(
                        $facilitator['email'],
                        'Solicitudes emparejadas (4 pax completo)',
                        array('requests' => $coupled ), 
                        'shared_travel', 
                        'SharedTravels.new_requests_coupled'
                    );
                    
                    $confirmed = true;
                    $confirmedReason = __d('shared_travels', 'fue emparejada con otras solicitudes para llenar las 4 plazas de uno de nuestros autos');

                } else { // No se encontraron couplings

                    // Buscar si este cliente tiene otras solicitudes activadas
                    $all_requests = $this->SharedTravel->findActiveRequests($request['SharedTravel']['email']);

                    // Buscar si tiene otras solicitudes activadas que no sean esta
                    $countOther = 0;
                    foreach ($all_requests as $r) {
                        if($r['SharedTravel']['id'] == $request['SharedTravel']['id']) continue;

                        $countOther++;
                    }

                    if($countOther == 0) {// Si es la primera solicitud (no tiene otras solicitudes), enviarle el correo de presentacion del operador
                        $OK = EmailsUtil::email(
                                $request['SharedTravel']['email'], 
                                __d('shared_travels', 'Tenemos los datos de su solicitud'),
                                array('request' => $request), 
                                'customer_assistant_shr', 
                                'SharedTravels.assistant_intro',
                                array('lang'=>$request['SharedTravel']['lang'])
                            );
                    } else { // Si tiene otras solicitudes, enviarle el correo de resumen
                        $OK = EmailsUtil::email(
                                $request['SharedTravel']['email'], 
                                __d('shared_travels', 'Tenemos los datos de su nueva solicitud'),
                                array('request' => $request, 'all_requests'=>$all_requests),
                                'customer_assistant_shr', 
                                'SharedTravels.requests_summary',
                                array('lang'=>$request['SharedTravel']['lang'])
                            );
                    }

                    // Correo a gestor para que confirme la solicitud
                    $facilitator = Configure::read('shared_rides_facilitator');
                    if($OK) $OK = EmailsUtil::email(
                        $facilitator['email'],
                        'Solicitud de viaje compartido '.'[['.$request['SharedTravel']['id_token'].']]',
                        array('request' => $request), 
                        'shared_travel', 
                        'SharedTravels.new_request'
                    );
                }
            }
        }        
        
        // Guardar algunos datos en la session para si el cliente quiere crear mas solicitudes que no tenga que repetirlas
        // TODO: Guardarlos en una Cookie???
        $this->Session->write('SharedTravels.email', $request['SharedTravel']['email']);
        $this->Session->write('SharedTravels.people_count', $request['SharedTravel']['people_count']);
        $this->Session->write('SharedTravels.name_id', $request['SharedTravel']['name_id']);
        
        return array('success'=>$OK, 'confirmed'=>$confirmed, 'confirmed_reason'=>$confirmedReason, 'coupled'=>$coupled);
    }
    
    public function view($token) {
        $request = $this->SharedTravel->findByIdToken($token);
        
        // Sanity checks
        if($request == null || empty ($request)) throw new NotFoundException();
        if(!$request['SharedTravel']['activated']) throw new NotFoundException();
        
        $this->set('request', $request);
    }
    
    public function admin($id) {
        $request = $this->SharedTravel->findById($id);
        
        // Sanity checks
        if($request == null || empty ($request)) throw new NotFoundException();
        
        $this->set('request', $request);
    }
    
    private function findCouplings($request) {
        
        // Buscar posibles emparejamiento para esta solicitud
        $candidates = $this->SharedTravel->find('all', array(
            'conditions'=>array(
                'modality_code'=>$request['SharedTravel']['modality_code'], // Que coincidan en la ruta y hora
                'date'=> TimeUtil::dateFormatBeforeSave($request['SharedTravel']['date']), // Que coincidan en la fecha
                'people_count <='=> 4 - $request['SharedTravel']['people_count'], // Que sumen no mas de 4 personas
                'email !='=>$request['SharedTravel']['email'], // Que no sea de este mismo cliente
                'activated'=>true, // Que este activada la solicitud
                'coupling_id'=>null,// Que no haya sido emparejado antes
                'state !='=>SharedTravel::$STATE_CONFIRMED // Que no este confirmado (por si el facilitador lo confirmo dirctamente).
                
            ),
            'order'=>'people_count DESC' // Obtener las de mas personas primero, para tener que hacer menos recorridos al recoger. TODO: sera mejor priorizar a las mas antiguas???
        ));
        
        // Armar los emparejamientos
        $count = $request['SharedTravel']['people_count'];
        $couplings = array();
        foreach ($candidates as $r) {
            if($count +  $r['SharedTravel']['people_count'] > 4) continue;
            
            $couplings[] = $r;
            $count += $r['SharedTravel']['people_count'];
        }
        if($count == 4) { // Emparejamiento exitoso
            return $couplings;
        } 
        
        return null;
    }
    
    
    
    
    
    public function change_date($id) {
        $this->SharedTravel->create(false); // se pasa false para evitar que se carguen los valores por defecto, esto evita que se sobreescriba el notification_type = D 
        $this->SharedTravel->id = $id;
        if(!$this->SharedTravel->exists()) throw new NotFoundException();
        
        if ($this->request->is('post') || $this->request->is('put')) {
            
            $new = array('SharedTravel'=>array_merge($this->request->data['SharedTravel'], array('id'=>$id)));
            
            $OK = $this->SharedTravel->save($new, false);
            if(!$OK) $this->setErrorMessage ('Error actualizando la fecha.');
            
            return $this->redirect($this->referer());
            
        } else throw new MethodNotAllowedException();
    }
}

?>