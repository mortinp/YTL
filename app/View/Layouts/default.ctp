<?php
// INITIALIZE
$isLoggedIn = AuthComponent::user('id') ? true : false;

if($isLoggedIn) {
    $user = AuthComponent::user();
    
    $role = $user['role'];
    if($user['display_name'] != null) {
        $splitName = explode('@', $user['display_name']);
        if(count($splitName) > 1) $pretty_user_name = $splitName[0];
        else $pretty_user_name = $user['display_name'];
    } else {
        $splitEmail = explode('@', $user['username']);
        $pretty_user_name = $splitEmail[0];
    }
    if($role === 'admin' || $role === 'tester') $pretty_user_name.= ' (<b>'.$role.'</b>)';
    //$pretty_user_date = date('M j, Y', strtotime($user['created']));
}

?>
<!DOCTYPE html>
<html>
    <head>        
        <?php echo $this->Html->charset(); ?>
        <title><?php echo "YoTeLlevo - Cuba | ".$page_title ?></title>
        <meta name="description" content="¿Necesitas alquilar un taxi para ir a cualquier parte de Cuba? Crea un anuncio de viaje en YoTeLlevo y enseguida conseguirás un chofer con carro que te lleve."/>
        
        <?php
        // META
        $this->Html->meta('icon');
        
        // CSS
        /*//$this->Html->css('prettify', array('inline' => false));
        $this->Html->css('bootstrap', array('inline' => false));        
        $this->Html->css('common/font-awesome.min', array('inline' => false));
        $this->Html->css('default', array('inline' => false));*/
        
        $this->Html->css('default-bundle', array('inline' => false));        
        
        //JS
        /*$this->Html->script('jquery', array('inline' => false));
        $this->Html->script('bootstrap', array('inline' => false));*/
        
        $this->Html->script('default-bundle', array('inline' => false));
        

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
        
        <script type="text/javascript">
            $(document).ready(function() {
                $('.info').tooltip({placement:'bottom', html:true});
            })
        </script>
    </head>
    <body>
        <div id="container">
            <nav id="app-navbar" class="navbar navbar-default" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#app-navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <div class="navbar-brand"><i class="glyphicon glyphicon-road"></i> <big>Yo</big>Te<big>Llevo</big></div>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <ul class="nav navbar-nav">
                            <?php if ($isLoggedIn) :?>
                            
                                <?php if($role === 'regular' || $role === 'admin' || $role === 'tester') :?>
                                    <li><?php echo $this->Html->link(__('Mis Anuncios'), array('controller' => 'travels', 'action' => 'index'), array('escape'=>false));?></li>
                                    <li class="divider-vertical"></li>
                                    <li><?php echo $this->Html->link('<span class="text-info"><b>'.__('Anunciar Viaje').'</b></span>', array('controller' => 'travels', 'action' => 'add'), array('escape'=>false));?></li> 
                                    
                                    <?php if($role === 'admin') :?>
                                    <li class="divider-vertical"></li>
                                    <li class="dropdown">
                                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                                            <?php echo __('Administrar')?>
                                            <b class="caret"></b>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class="dropdown-submenu">
                                                <a tabindex="-1" href="#"><?php echo __('Administrar')?></a>
                                                <ul class="dropdown-menu">
                                                    <li><?php echo $this->Html->link(__('Usuarios'), array('controller' => 'users', 'action' => 'index')) ?></li>
                                                    <li><?php echo $this->Html->link(__('Choferes'), array('controller' => 'drivers', 'action' => 'index')) ?></li>                                            
                                                    <li class="divider"></li>
                                                    <li><?php echo $this->Html->link(__('Provincias'), array('controller' => 'provinces', 'action' => 'index')) ?></li>
                                                    <li><?php echo $this->Html->link(__('Localidades'), array('controller' => 'localities', 'action' => 'index')) ?></li>
                                                    <li><?php echo $this->Html->link(__('Tesauro'), array('controller' => 'locality_thesaurus', 'action' => 'index')) ?></li>
                                                </ul>
                                            </li>
                                            <li class="dropdown-submenu">
                                                <a tabindex="-1" href="#"><?php echo __('Ver')?></a>
                                                <ul class="dropdown-menu">
                                                    <li><?php echo $this->Html->link(__('Viajes (Todos)'), array('controller' => 'travels', 'action' => 'all')) ?></li>
                                                    <li><?php echo $this->Html->link(__('Pendientes (Todos)'), array('controller' => 'travels', 'action' => 'all_pending')) ?></li>
                                                    <li class="divider"></li>
                                                    <li><?php echo $this->Html->link(__('Email Queue'), array('controller' => 'email_queues', 'action' => 'index')) ?></li>
                                                </ul>
                                            </li>
                                            <li class="dropdown-submenu">
                                                <a tabindex="-1" href="#"><?php echo __('Logs')?></a>
                                                <ul class="dropdown-menu">
                                                    <li><?php echo $this->Html->link(__('Info Requerida'), array('controller' => 'admins', 'action' => 'view_log/info_requested')) ?></li>
                                                    <li><?php echo $this->Html->link(__('Viajes por Correo'), array('controller' => 'admins', 'action' => 'view_log/travels_by_email')) ?></li>
                                                    <li><?php echo $this->Html->link(__('Viajes Fallidos'), array('controller' => 'admins', 'action' => 'view_log/travels_failed')) ?></li>
                                                </ul>
                                            </li>
                                            <li class="divider"></li>
                                            <li class="dropdown-submenu">
                                                <a tabindex="-1" href="#"><?php echo __('Tests')?></a>
                                                <ul class="dropdown-menu">
                                                    <li><?php echo $this->Html->link(__('Ver Viajes Admins'), array('controller' => 'travels', 'action' => 'all_admins')) ?></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <?php endif;?>
                                <?php endif;?>
                                    
                            <?php else: ?>
                                <li><?php echo $this->Html->link('<i class="glyphicon glyphicon-home"></i> '.__('Inicio'), '/', array('escape'=>false));?></li>
                            <?php endif;?>            
                        </ul>

                        <ul class="nav navbar-nav navbar-right">
                            <?php if ($isLoggedIn): ?>
                                <li class="dropdown">
                                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                                        <?php echo $pretty_user_name;?>
                                        <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><?php echo $this->Html->link(__('Perfil'), array('controller' => 'users', 'action' => 'profile')) ?></li>
                                        <li class="divider"></li>
                                        <li><?php echo $this->Html->link(__('Salir'), array('controller' => 'users', 'action' => 'logout')) ?></li>
                                    </ul>
                                </li>
                            <?php else: ?>
                                <li>
                                    <?php echo $this->Html->link(__('Entrar'), array('controller' => 'users', 'action' => 'login')) ?>
                                </li>
                                <li>
                                    <?php echo $this->Html->link(__('Registrarse'), array('controller' => 'users', 'action' => 'register')) ?>
                                </li>
                            <?php endif ?>

                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div>
            </nav>
            
            
            <?php echo $this->Session->flash('auth'); ?>

            <div id="content" class="container-fluid">
                <?php echo $this->Session->flash(); ?>
                <?php echo $this->fetch('content'); ?>
                
                <?php if( ROOT != 'C:\wamp\www\yotellevo' && (!$isLoggedIn || $role === 'regular') ):?>
                    <!-- Start 1FreeCounter.com code -->

                      <script language="JavaScript">
                      var data = '&r=' + escape(document.referrer)
                            + '&n=' + escape(navigator.userAgent)
                            + '&p=' + escape(navigator.userAgent)
                            + '&g=' + escape(document.location.href);

                      if (navigator.userAgent.substring(0,1)>'3')
                        data = data + '&sd=' + screen.colorDepth 
                            + '&sw=' + escape(screen.width+'x'+screen.height);

                      document.write('<a href="http://www.1freecounter.com/stats.php?i=107146" target=\"_blank\" >');
                      document.write('<img alt="Free Counter" border=0 hspace=0 '+'vspace=0 src="http://www.1freecounter.com/counter.php?i=107146' + data + '">');
                      document.write('</a>');
                      </script>

                    <!-- End 1FreeCounter.com code -->
                <?php endif;?>
                
                
            </div>

            <div id="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3">
                            <p class="text-muted" style="margin: 20px 0;">
                                <?php echo __('Creado por')?> <a href="http://ksabes.com">Casabe&trade;</a>
                            </p>
                        </div>
                        <div class="col-md-6" style="text-align: center">
                            <p class="text-muted" style="margin: 20px 0;">
                               <?php echo $this->Html->link(__('Contactar'), array('controller'=>'pages', 'action'=>'display', 'contact')); ?>                                
                                |
                               <?php echo $this->Html->link(__('Preguntas Frecuentes'), array('controller'=>'pages', 'action'=>'display', 'faq')); ?>
                            </p>
                            
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </body>
</html>
