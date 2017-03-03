<?php
Router::connect('/:language/search', array('plugin'=>'searches', 'controller' => 'search'), array('language' => 'en|es'));
Router::connect('/:language/search/:action/*', array('plugin'=>'searches', 'controller' => 'search'), array('language' => 'en|es'));
?>