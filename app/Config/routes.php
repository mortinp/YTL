<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
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
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	//Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
        Router::connect('/:language', array('controller' => 'pages', 'action' => 'display', 'home'), array('language' => 'en|es'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	//Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
        Router::connect('/:language/pages/*', array('controller' => 'pages', 'action' => 'display'), array('language' => 'en|es'));
        
        
        // Estas son rutas con alias para que los usuarios vean url mas bonitas...
        Router::connect('/:language/conversations/messages/*', array('controller' => 'driver_traveler_conversations', 'action'=>'messages'), array('language' => 'en|es'));
        Router::connect('/:language/conversations/*', array('controller' => 'driver_travels', 'action'=>'index'), array('language' => 'en|es'));
        
        Router::connect('/:language/requests/view/*', array('controller' => 'travels', 'action'=>'view'), array('language' => 'en|es'));
        Router::connect('/:language/requests/*', array('controller' => 'travels', 'action'=>'index'), array('language' => 'en|es'));
        
        
        
        
        /*MARTIN*/
        //Router::connect('/lang/*', array('controller' => 'lang', 'action' => 'setlang'));
        
        // Plugins urls
        //Router::connect('/email_queues/:action/*', array('plugin'=>'email_queue', 'controller' => 'email_queues'));
        //Router::connect('/email_queues', array('plugin'=>'email_queue', 'controller' => 'email_queues'));
        Router::connect('/:language/email_queues/:action/*', array('plugin'=>'email_queue', 'controller' => 'email_queues'), array('language' => 'en|es'));
        Router::connect('/:language/email_queues', array('plugin'=>'email_queue', 'controller' => 'email_queues'), array('language' => 'en|es'));
        
        //Router::connect('/casas/:action/*', array('plugin'=>'casas', 'controller' => 'casas'));
        Router::connect('/:language/casas/:action/*', array('plugin'=>'casas', 'controller' => 'casas'), array('language' => 'en|es'));
        
        //Router::connect('/url_invitations/:action/*', array('plugin'=>'invitations', 'controller' => 'url_invitations'));
        //Router::connect('/url_invitations', array('plugin'=>'invitations', 'controller' => 'url_invitations'));
        Router::connect('/:language/url_invitations/:action/*', array('plugin'=>'invitations', 'controller' => 'url_invitations'), array('language' => 'en|es'));
        Router::connect('/:language/url_invitations', array('plugin'=>'invitations', 'controller' => 'url_invitations'), array('language' => 'en|es'));
        
        //Router::connect('/op_action_rules/:action/*', array('plugin'=>'operations', 'controller' => 'op_action_rules'));
        //Router::connect('/op_action_rules', array('plugin'=>'operations', 'controller' => 'op_action_rules'));
        Router::connect('/:language/op_action_rules/:action/*', array('plugin'=>'operations', 'controller' => 'op_action_rules'), array('language' => 'en|es'));
        Router::connect('/:language/op_action_rules', array('plugin'=>'operations', 'controller' => 'op_action_rules'), array('language' => 'en|es'));
        
        Router::connect('/:language/search/:action/*', array('plugin'=>'search', 'controller' => 'search'), array('language' => 'en|es'));
        Router::connect('/:language/search', array('plugin'=>'search', 'controller' => 'search'), array('language' => 'en|es'));
        
        
        # prevent routing conflicts with plugins...
        # http://www.omaroid.com/cakephp-locale-language-routing/
        // make an array of loaded plugins
        $loaded = CakePlugin::loaded();
        array_walk($loaded, function(&$item,$key){
            $item = Inflector::underscore($item);
        });
        $loaded = implode('|', $loaded);

        Router::connect('/:language/:plugin/:controller/:action/*', 
                            array(), 
                            array('language' => 'en|es','plugin' => "($loaded)"));
        
        /*     Router::connect('/:language',
                           array('controller' => 'pages', 'action' => 'display', 'home'),
                           array('language' => 'en|es')); */

        Router::connect('/:language/:controller',
                           array('action' => 'index'),
                           array('language' => 'en|es')); 

        Router::connect('/:language/:controller/:action/*',
                               array(),
                               array('language' => 'en|es'));
        

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
