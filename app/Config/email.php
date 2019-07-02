<?php

/**
 * This is email configuration file.
 *
 * Use it to configure email transports of Cake.
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
 * @package       app.Config
 * @since         CakePHP(tm) v 2.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 *
 * Email configuration class.
 * You can specify multiple configurations for production, development and testing.
 *
 * transport => The name of a supported transport; valid options are as follows:
 * 		Mail 		- Send using PHP mail function
 * 		Smtp		- Send using SMTP
 * 		Debug		- Do not send the email, just return the result
 *
 * You can add custom transports (or override existing transports) by adding the
 * appropriate file to app/Network/Email. Transports should be named 'YourTransport.php',
 * where 'Your' is the name of the transport.
 *
 * from =>
 * The origin email. See CakeEmail::from() about the valid values
 *
 */
class EmailConfig {
    
    public $no_responder = array(
        'transport' => 'Smtp',
        'from' => array('no-responder@yotellevocuba.com' => 'YoTeLlevo'),
        'host' => 'localhost',
        'port' => 25, 
        'timeout' => 30,
        //'username' => '',
        //'password' => '',
        'client' => null,
        'log' => false,
        //'charset' => 'utf-8',
    );
    
    public $contacto = array(
        'transport' => 'Smtp',
        'from' => array('contacto@yotellevocuba.com' => 'YoTeLlevo | Contacto'),
        'host' => 'localhost',
        'port' => 25, 
        'timeout' => 30,
        //'username' => '',
        //'password' => '',
        'client' => null,
        'log' => false,
        //'charset' => 'utf-8',
    );
    
    public $soporte = array(
        'transport' => 'Smtp',
        'from' => array('soporte@yotellevocuba.com' => 'YoTeLlevo | Soporte'),
        'host' => 'localhost',
        'port' => 25, 
        'timeout' => 30,
        //'username' => '',
        //'password' => '',
        'client' => null,
        'log' => false,
        //'charset' => 'utf-8',
    );    
    
    /*public $info = array(
        'transport' => 'Smtp',
        'from' => array('mproenza@grm.desoft.cu' => 'YoTeLlevo | Info'),
        'host' => 'data',
        'port' => 25, 
        'timeout' => 30,
        //'username' => '',
        //'password' => '',
        'client' => null,
        'log' => false,
        //'charset' => 'utf-8',
    );*/
    
    
    
    public $chofer = array(
        'transport' => 'Smtp',
        'from' => array('chofer@yotellevocuba.com' => 'YoTeLlevo | Chofer'),
        'host' => 'localhost',
        'port' => 25, 
        'timeout' => 30,
        //'username' => '',
        //'password' => '',
        'client' => null,
        'log' => false,
        //'charset' => 'utf-8',
    );
    
    public $viajero = array(
        'transport' => 'Smtp',
        'from' => array('viajero@yotellevocuba.com' => 'YoTeLlevo | Viajero'),
        'host' => 'localhost',
        'port' => 25, 
        'timeout' => 30,
        //'username' => '',
        //'password' => '',
        'client' => null,
        'log' => false,
        //'charset' => 'utf-8',
    );
}
