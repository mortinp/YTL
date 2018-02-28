<?php
App::uses('AppModel', 'Model');
App::uses('CakeTime', 'Utility');
App::uses('TimeUtil', 'Util');
App::uses('CakeEmail', 'Network/Email');

class SharedTravel extends AppModel {
    
    public static $localities = array(
        0=>'La Habana', 
        1=>'Trinidad', 
        2=>'Viñales', 
        3=>'Varadero', 
        4=>'Cienfuegos', 
        7=>'Santa Clara',
        5=>'Cayo Coco', 
        6=>'Cayo Guillermo', 
        8=>'Playa Larga', 
        9=>'Playa Girón', 
    );
    
    public static $modalities = array(
        // El origin_id y el destination_id son indicadores unicos de cada lugar que se usan para recomendar transfers
        'HABTRI8'=>array('origin_id'=>0, 'destination_id'=>1, 'origin'=>'La Habana', 'destination'=>'Trinidad', 'time'=>'8 am', 'price'=>35),
        'HABTRI14'=>array('origin_id'=>0, 'destination_id'=>1, 'origin'=>'La Habana', 'destination'=>'Trinidad', 'time'=>'2 pm', 'price'=>35),
        'HABVIN8'=>array('origin_id'=>0, 'destination_id'=>2, 'origin'=>'La Habana', 'destination'=>'Viñales', 'time'=>'8 am', 'price'=>25, 'active'=>false),
        'HABVIN12'=>array('origin_id'=>0, 'destination_id'=>2, 'origin'=>'La Habana', 'destination'=>'Viñales', 'time'=>'12 pm', 'price'=>25, 'active'=>false),
        'HABVIN11'=>array('origin_id'=>0, 'destination_id'=>2, 'origin'=>'La Habana', 'destination'=>'Viñales', 'time'=>'11 am', 'price'=>25),
        'HABVAR8'=>array('origin_id'=>0, 'destination_id'=>3, 'origin'=>'La Habana', 'destination'=>'Varadero', 'time'=>'8 am', 'price'=>25, 'active'=>false),
        'HABVAR14'=>array('origin_id'=>0, 'destination_id'=>3, 'origin'=>'La Habana', 'destination'=>'Varadero', 'time'=>'2 pm', 'price'=>25),
        'HABCFG8'=>array('origin_id'=>0, 'destination_id'=>4, 'origin'=>'La Habana', 'destination'=>'Cienfuegos', 'time'=>'8 am', 'price'=>35),
        'HABCFG14'=>array('origin_id'=>0, 'destination_id'=>4, 'origin'=>'La Habana', 'destination'=>'Cienfuegos', 'time'=>'2 pm', 'price'=>35),
        'HABSCL8'=>array('origin_id'=>0, 'destination_id'=>7, 'origin'=>'La Habana', 'destination'=>'Santa Clara', 'time'=>'8 am', 'price'=>35),
        'HABSCL14'=>array('origin_id'=>0, 'destination_id'=>7, 'origin'=>'La Habana', 'destination'=>'Santa Clara', 'time'=>'2 pm', 'price'=>35),
        'HABPLL8'=>array('origin_id'=>0, 'destination_id'=>8, 'origin'=>'La Habana', 'destination'=>'Playa Larga', 'time'=>'8 am', 'price'=>30),
        'HABPLL14'=>array('origin_id'=>0, 'destination_id'=>8, 'origin'=>'La Habana', 'destination'=>'Playa Larga', 'time'=>'2 pm', 'price'=>30),
        'HABPLG8'=>array('origin_id'=>0, 'destination_id'=>9, 'origin'=>'La Habana', 'destination'=>'Playa Girón', 'time'=>'8 am', 'price'=>30),
        'HABPLG14'=>array('origin_id'=>0, 'destination_id'=>9, 'origin'=>'La Habana', 'destination'=>'Playa Girón', 'time'=>'2 pm', 'price'=>30),
        
        'TRIHAB8'=>array('origin_id'=>1, 'destination_id'=>0, 'origin'=>'Trinidad', 'destination'=>'La Habana', 'time'=>'8 am', 'price'=>35),
        'TRIHAB14'=>array('origin_id'=>1, 'destination_id'=>0, 'origin'=>'Trinidad', 'destination'=>'La Habana', 'time'=>'2 pm', 'price'=>35),
        'TRIVIN8'=>array('origin_id'=>1, 'destination_id'=>2, 'origin'=>'Trinidad', 'destination'=>'Viñales', 'time'=>'8 am', 'price'=>50),
        'TRIVAR8'=>array('origin_id'=>1, 'destination_id'=>3, 'origin'=>'Trinidad', 'destination'=>'Varadero', 'time'=>'8 am', 'price'=>35),
        'TRIVAR14'=>array('origin_id'=>1, 'destination_id'=>3,'origin'=>'Trinidad', 'destination'=>'Varadero', 'time'=>'2 pm', 'price'=>35),
        'TRICAM8'=>array('origin_id'=>1, 'destination_id'=>-1, 'origin'=>'Trinidad', 'destination'=>'Cayo Santa María', 'time'=>'8 am', 'price'=>35),
        'TRICAC8'=>array('origin_id'=>1, 'destination_id'=>5, 'origin'=>'Trinidad', 'destination'=>'Cayo Coco', 'time'=>'8 am', 'price'=>35),
        'TRICAG8'=>array('origin_id'=>1, 'destination_id'=>6, 'origin'=>'Trinidad', 'destination'=>'Cayo Guillermo', 'time'=>'8 am', 'price'=>40),
        'TRIPLL8'=>array('origin_id'=>1, 'destination_id'=>8, 'origin'=>'Trinidad', 'destination'=>'Playa Larga', 'time'=>'8 am', 'price'=>30),
        'TRIPLL14'=>array('origin_id'=>1, 'destination_id'=>8, 'origin'=>'Trinidad', 'destination'=>'Playa Larga', 'time'=>'2 pm', 'price'=>30),
        'TRIPLG8'=>array('origin_id'=>1, 'destination_id'=>9, 'origin'=>'Trinidad', 'destination'=>'Playa Girón', 'time'=>'8 am', 'price'=>30),
        'TRIPLG14'=>array('origin_id'=>1, 'destination_id'=>9, 'origin'=>'Trinidad', 'destination'=>'Playa Girón', 'time'=>'2 pm', 'price'=>30),
        
        'VINHAB8'=>array('origin_id'=>2, 'destination_id'=>0, 'origin'=>'Viñales', 'destination'=>'La Habana', 'time'=>'8 am', 'price'=>25),
        'VINHAB14'=>array('origin_id'=>2, 'destination_id'=>0, 'origin'=>'Viñales', 'destination'=>'La Habana', 'time'=>'2 pm', 'price'=>25),        
        'VINVAR8'=>array('origin_id'=>2, 'destination_id'=>3, 'origin'=>'Viñales', 'destination'=>'Varadero', 'time'=>'8 am', 'price'=>45),
        'VINVAR14'=>array('origin_id'=>2, 'destination_id'=>3, 'origin'=>'Viñales', 'destination'=>'Varadero', 'time'=>'2 pm', 'price'=>45),        
        'VINTRI8'=>array('origin_id'=>2, 'destination_id'=>1, 'origin'=>'Viñales', 'destination'=>'Trinidad', 'time'=>'8 am', 'price'=>50),
        'VINCFG8'=>array('origin_id'=>2, 'destination_id'=>4, 'origin'=>'Viñales', 'destination'=>'Cienfuegos', 'time'=>'8 am', 'price'=>50),
        'VINSCL8'=>array('origin_id'=>2, 'destination_id'=>7, 'origin'=>'Viñales', 'destination'=>'Santa Clara', 'time'=>'8 am', 'price'=>45),
        'VINPLL8'=>array('origin_id'=>2, 'destination_id'=>8, 'origin'=>'Viñales', 'destination'=>'Playa Larga', 'time'=>'8 am', 'price'=>40),
        'VINPLG8'=>array('origin_id'=>2, 'destination_id'=>9, 'origin'=>'Viñales', 'destination'=>'Playa Girón', 'time'=>'8 am', 'price'=>45),
        
        'VARHAB8'=>array('origin_id'=>3, 'destination_id'=>0, 'origin'=>'Varadero', 'destination'=>'La Habana', 'time'=>'8 am', 'price'=>30),
        'VARHAB14'=>array('origin_id'=>3, 'destination_id'=>0, 'origin'=>'Varadero', 'destination'=>'La Habana', 'time'=>'2 pm', 'price'=>25, 'active'=>false),
        /*'VARTRI14'=>array('origin_id'=>3, 'destination_id'=>1, 'origin'=>'Varadero', 'destination'=>'Trinidad', 'time'=>'2 pm', 'price'=>35),
        'VARCFG14'=>array('origin_id'=>3, 'destination_id'=>4, 'origin'=>'Varadero', 'destination'=>'Cienfuegos', 'time'=>'2 pm', 'price'=>35),*/
        
        'CFGHAB8'=>array('origin_id'=>4, 'destination_id'=>0, 'origin'=>'Cienfuegos', 'destination'=>'La Habana', 'time'=>'8 am', 'price'=>35),
        'CFGHAB14'=>array('origin_id'=>4, 'destination_id'=>0, 'origin'=>'Cienfuegos', 'destination'=>'La Habana', 'time'=>'2 pm', 'price'=>35),
        'CFGTRI7'=>array('origin_id'=>4, 'destination_id'=>1, 'origin'=>'Cienfuegos', 'destination'=>'Trinidad', 'time'=>'7 am', 'price'=>15),
        'CFGVIN8'=>array('origin_id'=>4, 'destination_id'=>2, 'origin'=>'Cienfuegos', 'destination'=>'Viñales', 'time'=>'8 am', 'price'=>50),
        'CFGVAR8'=>array('origin_id'=>4, 'destination_id'=>3, 'origin'=>'Cienfuegos', 'destination'=>'Varadero', 'time'=>'8 am', 'price'=>35),
        'CFGVAR14'=>array('origin_id'=>4, 'destination_id'=>3,'origin'=>'Cienfuegos', 'destination'=>'Varadero', 'time'=>'2 pm', 'price'=>35),
        'CFGCAC8'=>array('origin_id'=>4, 'destination_id'=>5, 'origin'=>'Cienfuegos', 'destination'=>'Cayo Coco', 'time'=>'8 am', 'price'=>40),
        'CFGCAG8'=>array('origin_id'=>4, 'destination_id'=>6, 'origin'=>'Cienfuegos', 'destination'=>'Cayo Guillermo', 'time'=>'8 am', 'price'=>45),
        'CFGPLL8'=>array('origin_id'=>4, 'destination_id'=>8, 'origin'=>'Cienfuegos', 'destination'=>'Playa Larga', 'time'=>'8 am', 'price'=>30),
        'CFGPLL14'=>array('origin_id'=>4, 'destination_id'=>8, 'origin'=>'Cienfuegos', 'destination'=>'Playa Larga', 'time'=>'2 pm', 'price'=>30),
        'CFGPLG8'=>array('origin_id'=>4, 'destination_id'=>9, 'origin'=>'Cienfuegos', 'destination'=>'Playa Girón', 'time'=>'8 am', 'price'=>30),
        'CFGPLG14'=>array('origin_id'=>4, 'destination_id'=>9, 'origin'=>'Cienfuegos', 'destination'=>'Playa Girón', 'time'=>'2 pm', 'price'=>30),
        
        'CACHAB14'=>array('origin_id'=>5, 'destination_id'=>0, 'origin'=>'Cayo Coco', 'destination'=>'La Habana', 'time'=>'2 pm', 'price'=>50),
        'CACTRI14'=>array('origin_id'=>5, 'destination_id'=>1, 'origin'=>'Cayo Coco', 'destination'=>'Trinidad', 'time'=>'2 pm', 'price'=>35),
        'CACVAR14'=>array('origin_id'=>5, 'destination_id'=>3, 'origin'=>'Cayo Coco', 'destination'=>'Varadero', 'time'=>'2 pm', 'price'=>50),
        'CACSCL14'=>array('origin_id'=>5, 'destination_id'=>7, 'origin'=>'Cayo Coco', 'destination'=>'Santa Clara', 'time'=>'2 pm', 'price'=>45),
        
        'CAGHAB14'=>array('origin_id'=>6, 'destination_id'=>0, 'origin'=>'Cayo Guillermo', 'destination'=>'La Habana', 'time'=>'2 pm', 'price'=>55),
        'CAGTRI14'=>array('origin_id'=>6, 'destination_id'=>1, 'origin'=>'Cayo Guillermo', 'destination'=>'Trinidad', 'time'=>'2 pm', 'price'=>40),
        'CAGVAR14'=>array('origin_id'=>6, 'destination_id'=>3, 'origin'=>'Cayo Guillermo', 'destination'=>'Varadero', 'time'=>'2 pm', 'price'=>55),
        'CAGSCL14'=>array('origin_id'=>6, 'destination_id'=>7, 'origin'=>'Cayo Guillermo', 'destination'=>'Santa Clara', 'time'=>'2 pm', 'price'=>50),
        
        'SCLHAB8'=>array('origin_id'=>7, 'destination_id'=>0, 'origin'=>'Santa Clara', 'destination'=>'La Habana', 'time'=>'8 am', 'price'=>35),
        'SCLVIN8'=>array('origin_id'=>7, 'destination_id'=>2, 'origin'=>'Santa Clara', 'destination'=>'Viñales', 'time'=>'8 am', 'price'=>45),        
        'SCLVAR8'=>array('origin_id'=>7, 'destination_id'=>3, 'origin'=>'Santa Clara', 'destination'=>'Varadero', 'time'=>'8 am', 'price'=>35),        
        'SCLPLL8'=>array('origin_id'=>7, 'destination_id'=>8, 'origin'=>'Santa Clara', 'destination'=>'Playa Larga', 'time'=>'8 am', 'price'=>35),        
        'SCLPLG8'=>array('origin_id'=>7, 'destination_id'=>9, 'origin'=>'Santa Clara', 'destination'=>'Playa Girón', 'time'=>'8 am', 'price'=>35),        
        
        'PLLHAB8'=>array('origin_id'=>8, 'destination_id'=>0, 'origin'=>'Playa Larga', 'destination'=>'La Habana', 'time'=>'8 am', 'price'=>30),
        'PLLHAB10'=>array('origin_id'=>8, 'destination_id'=>0, 'origin'=>'Playa Larga', 'destination'=>'La Habana', 'time'=>'10 am', 'price'=>30),
        'PLLVIN8'=>array('origin_id'=>8, 'destination_id'=>2, 'origin'=>'Playa Larga', 'destination'=>'Viñales', 'time'=>'8 am', 'price'=>40),
        'PLLVIN10'=>array('origin_id'=>8, 'destination_id'=>2, 'origin'=>'Playa Larga', 'destination'=>'Viñales', 'time'=>'10 am', 'price'=>40),
        'PLLTRI11'=>array('origin_id'=>8, 'destination_id'=>1, 'origin'=>'Playa Larga', 'destination'=>'Trinidad', 'time'=>'11 am', 'price'=>30),
        'PLLTRI16'=>array('origin_id'=>8, 'destination_id'=>1, 'origin'=>'Playa Larga', 'destination'=>'Trinidad', 'time'=>'4 pm', 'price'=>30),
        'PLLCFG11'=>array('origin_id'=>8, 'destination_id'=>4, 'origin'=>'Playa Larga', 'destination'=>'Cienfuegos', 'time'=>'11 am', 'price'=>30),
        'PLLCFG16'=>array('origin_id'=>8, 'destination_id'=>4, 'origin'=>'Playa Larga', 'destination'=>'Cienfuegos', 'time'=>'4 pm', 'price'=>30),        
        
        'PLGHAB8'=>array('origin_id'=>9, 'destination_id'=>0, 'origin'=>'Playa Girón', 'destination'=>'La Habana', 'time'=>'8 am', 'price'=>30),
        'PLGHAB10'=>array('origin_id'=>9, 'destination_id'=>0, 'origin'=>'Playa Girón', 'destination'=>'La Habana', 'time'=>'10 am', 'price'=>30),
        'PLGVIN8'=>array('origin_id'=>9, 'destination_id'=>2, 'origin'=>'Playa Girón', 'destination'=>'Viñales', 'time'=>'8 am', 'price'=>45),
        'PLGVIN10'=>array('origin_id'=>9, 'destination_id'=>2, 'origin'=>'Playa Girón', 'destination'=>'Viñales', 'time'=>'10 am', 'price'=>45),
        'PLGTRI11'=>array('origin_id'=>9, 'destination_id'=>1, 'origin'=>'Playa Girón', 'destination'=>'Trinidad', 'time'=>'11 am', 'price'=>30),
        'PLGTRI16'=>array('origin_id'=>9, 'destination_id'=>1, 'origin'=>'Playa Girón', 'destination'=>'Trinidad', 'time'=>'4 pm', 'price'=>30),
        'PLGCFG11'=>array('origin_id'=>9, 'destination_id'=>4, 'origin'=>'Playa Girón', 'destination'=>'Cienfuegos', 'time'=>'11 am', 'price'=>30),
        'PLGCFG16'=>array('origin_id'=>9, 'destination_id'=>4, 'origin'=>'Playa Girón', 'destination'=>'Cienfuegos', 'time'=>'4 pm', 'price'=>30),
        );
    
    public static $STATE_PENDING = 'P'; // Cuando se crea
    public static $STATE_ACTIVATED = 'A'; //Cuando se activa (se le envian los datos a Andiel para comenzar a gestionar)
    public static $STATE_CONFIRMED = 'C'; // Cuando se confirma que se puede realizar (Andiel confirma)
    public static $STATE_CANCELLED = 'X'; //
    public static $STATE_DONE = 'D'; //
    
    public $validate = array(
        'date' => array(
            'isDate' => array(
                'rule' => array('date', array('dmy', 'ymd')),
                'message' => 'La fecha tiene un formato incorrecto.',
                'required' => true
            )
        ),
        'people_count' => array(
            'isNumber' => array(
                'rule' => 'numeric',
                'message' => 'La cantidad de personas debe ser un número entero.',
                'required' => true
            ),
            'notZero' => array(
                'rule' => array('comparison', '>=', 1),
                'message' => 'La cantidad de personas no puede ser 0.',
                'required' => true
            )
        )
    );
    
    public static function getStateDesc($state) {
        
        $desc = array('title'=>__d('shared_travels', 'Pendiente'), 'class'=>'label label-warning', 'description'=>__d('shared_travels', 'No has activado esta solicitud por lo cual no hemos empezado las gestiones. Revisa tu correo y dale click al enlace que te enviamos.'));
        if($state == SharedTravel::$STATE_ACTIVATED) $desc = array('title'=>__d('shared_travels', 'Activada / No confirmada'), 'class'=>'label label-info', 'description'=>__d('shared_travels', 'Ya activaste la solicitud y ahora estamos haciendo las gestiones. Te enviaremos un email con la confirmación de la recogida en la fecha y dirección indicada.'));
        else if($state == SharedTravel::$STATE_CONFIRMED) $desc = array('title'=>__d('shared_travels', 'Confirmada'), 'class'=>'label label-success', 'description'=>__d('shared_travels', 'Ya tu viaje se encuentra en nuestra agenda para la fecha, hora y lugar indicado. Un taxi te buscará ese día a tu puerta!'));
        else if($state == SharedTravel::$STATE_CANCELLED) $desc = array('title'=>__d('shared_travels', 'Cancelada'), 'class'=>'label label-danger', 'description'=>__d('shared_travels', 'La solicitud fue cancelada por tí o por los administradores. La recogida está suspendida.'));
        
        return $desc;
    }
    
    
    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['date'])) {
            if($this->useDbConfig == 'mysql') {
                // Guardar como YYYY/mm/dd
                $d = str_replace('-', '/', $this->data[$this->alias]['date']);
                $d = explode('/', $d);
                $newD = $d['2'].'-'.$d[1].'-'.$d[0];
                $this->data[$this->alias]['date'] = $newD;
            }   
        }
        if (isset($this->data[$this->alias]['email'])) {
                $this->data[$this->alias]['email'] = strtolower($this->data[$this->alias]['email']);
        }
        return true;
    }
    
    public function beforeFind($query = array()) {
        
        if(isset($query['conditions']['email'])) $query['conditions']['email'] = strtolower ($query['conditions']['email']);
        if(isset($query['conditions']['SharedTravel.email'])) $query['conditions']['SharedTravel.email'] = strtolower ($query['conditions']['SharedTravel.email']);
        if(isset($query['conditions']['email !='])) $query['conditions']['email !='] = strtolower ($query['conditions']['email !=']);
        if(isset($query['conditions']['SharedTravel.email !='])) $query['conditions']['SharedTravel.email !='] = strtolower ($query['conditions']['SharedTravel.email !=']);
        
        return $query;
    }
    
    public function afterFind($results, $primary = false) {
        foreach ($results as $key => $val) {
            if (isset($val[$this->alias]['date'])) {
                $results[$key][$this->alias]['date'] = TimeUtil::dateFormatAfterFind($val[$this->alias]['date']);
                
                $date_converted = strtotime($val[$this->alias]['date']);
                $expired = CakeTime::isPast($date_converted) && !CakeTime::isToday($date_converted);
                $results[$key][$this->alias]['is_expired'] = $expired;
            }
        }
        return $results;
    }
    
    //Encuentra las solicitudes activas de un usuario
    public function findActiveRequests($userEmail) {
        $today = date('Y-m-d', strtotime('today'));
        
        return $this->find('all', 
                array(
                    'conditions'=>array(
                        'email'=>$userEmail, // Que sean de este usuario
                        'activated'=>true, // Que esten activadas
                        'state !='=>SharedTravel::$STATE_CANCELLED, // Que NO esten canceladas
                        'date >'=>$today // Que no esten expiradas
                        ),

                    'order'=>'SharedTravel.date ASC, SharedTravel.id ASC'
                )
            );
    }
    
    
    public function confirmRequest($request) {
        $this->create();
        
        $this->id = $request['SharedTravel']['id'];
        $OK = $this->saveField('state', SharedTravel::$STATE_CONFIRMED);
        
        if($OK) {
            $lang = $request['SharedTravel']['lang'];

            $subject = 'Viaje compartido confirmado!';
            if($lang == 'en') $subject = 'Shared ride confirmed!';
            
            // Buscar todas las solicitudes activadas para mostrarle al cliente el resumen
            $all_requests = $this->findActiveRequests($request['SharedTravel']['email']);

            $OK = EmailsUtil::email(
                $request['SharedTravel']['email'], 
                $subject,
                array('request' => $request, 'all_requests'=>$all_requests),
                'customer_assistant_shr', 
                'SharedTravels.request_confirmed',
                array('lang'=>$lang)
            );
            
            // Email para mi
            $Email = new CakeEmail('no_responder');
            $Email->to('martin@yotellevocuba.com')->subject('Viaje compartido confirmado')->send('http://yotellevocuba.com/shared-rides/view/'.$request['SharedTravel']['id_token']);
        }
        
        return $OK;
    }
}

?>