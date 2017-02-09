<?php App::uses('Travel', 'Model')?>
<?php App::uses('DriverTravel', 'Model')?>
<?php App::uses('User', 'Model')?>

<?php
$userLoggedIn = AuthComponent::user('id') ? true : false;

if($userLoggedIn) {
    $user = AuthComponent::user();
    $userRole = $user['role'];
    $pretty_user_name = User::prettyName($user, true);
}
?>

<?php     
    $other = array('en' => 'es', 'es' => 'en');
    $lang = $this->Session->read('Config.language');
 
    $lang_changed_url             = $this->request['pass'];
    $lang_changed_url             = array_merge($lang_changed_url, $this->request['named']);
    $lang_changed_url['?']        = $this->request->query;
    $lang_changed_url['language'] = $other[$lang];
?>

<!DOCTYPE html>
<html>
    <head>        
        <?php echo $this->Html->charset(); ?>
        <title><?php echo $page_title." | YoTeLlevo" ?></title>
        <meta name="description" content="<?php echo $page_description?>"/>
        
        <style type="text/css">
            
            #navbar #nav a.nav-link{
                /*color:white;*/
                font-family:'Montserrat', sans-serif;
                font-size:13px;
                /*margin-top:4px;*/
                text-transform:uppercase
            }
            #navbar #nav a.nav-link:hover,#navbar #nav a.nav-link:focus{
                background-color:transparent;
                text-decoration:none
            }
        </style>
        
        <?php
        // META
        $this->Html->meta('icon');
        
        $this->Html->css('default-bundle', array('inline' => false));
        
        $this->Html->script('default-bundle', array('inline' => false));

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
        
        <script type="text/javascript">
            $(document).ready(function() {
                
                $.each($('.info'), function(pos, obj) {
                    var placement = 'bottom';
                    if($(obj).attr('data-placement') !== undefined) placement = $(obj).attr('data-placement');
                    $(obj).tooltip({placement:placement, html:true});
                });
                
                //$('.info').tooltip({placement:'bottom', html:true});
            })
        </script>
    </head>
    <body>
        <div id="container">
            <div id="navbar" class="navbar navbar-default" role="navigation">
                <nav id="nav">
                <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#app-navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                            <span class="white navbar-brand"><big>Yo</big>Te<big>Llevo</big></span>
                        <div class="pull-left navbar-brand">
                            <?php $lang = SessionComponent::read('Config.language');?>
                            <?php if($lang != null && $lang == 'en'):?>
                                <div class="nav-link info" title="Traducir al Español"><?php echo $this->Html->link($this->Html->image('Spain.png'), $lang_changed_url, array('escape'=>false, 'style'=>'text-decoration:none')) ?></div>
                            <?php else:?>
                                <div class="nav-link info" title="Translate to English"><?php echo $this->Html->link($this->Html->image('UK.png'), $lang_changed_url, array('escape'=>false, 'style'=>'text-decoration:none')) ?></div>
                            <?php endif;?>
                        </div>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <ul class="nav navbar-nav">
                            
                            <?php if ($userLoggedIn) :?>
                                <?php if($userRole === 'admin' || $userRole === 'operator'):?>

                                    <li title="Revisa todas las conversaciones que tienen nuevos mensajes y mantente al tanto de los acuerdos entre choferes y viajeros." class="info">
                                        <?php echo $this->Html->link('<button type="button" class="btn btn-success navbar-btn">Nuevos Mensajes</button>', array('controller' => 'driver_travels', 'action' => 'view_filtered', DriverTravel::$SEARCH_NEW_MESSAGES), array('escape'=>false, 'style'=>'padding:0px;padding-right:10px'))?>
                                    </li>
                                    <li title="Chequea las conversaciones de los próximos viajes que expiran y que se están Siguiendo y asegúrate que todo está bien." class="info">
                                        <?php echo $this->Html->link('<button type="button" class="btn btn-info navbar-btn">Conversaciones Siguiendo</button>', array('controller' => 'driver_travels', 'action' => 'view_filtered', DriverTravel::$SEARCH_FOLLOWING), array('escape'=>false, 'style'=>'padding:0px;padding-right:10px'))?>
                                    </li>
                                    <li title="Mira los datos y las conversaciones de las últimas solicitudes de viaje creadas. Verifica cómo se comporta la interacción entre choferes y viajeros y notifica otros choferes si es necesario." class="info">
                                        <?php echo $this->Html->link('<button type="button" class="btn btn-default navbar-btn">Solicitudes de Viajes</button>', array('controller' => 'travels', 'action' => 'view_filtered', Travel::$SEARCH_ALL), array('escape'=>false, 'style'=>'padding:0px;padding-right:10px'))?>
                                    </li>

                                    <li class="divider-vertical"></li>

                                    <li class="dropdown">
                                        <a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link">
                                            Opciones
                                            <b class="caret"></b>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class="dropdown-submenu">
                                                <a tabindex="-1" href="#">Administrar</a>
                                                <ul class="dropdown-menu">
                                                    <li><?php echo $this->Html->link('Usuarios', array('controller' => 'users', 'action' => 'index')) ?></li>
                                                    <li><?php echo $this->Html->link('Choferes', array('controller' => 'drivers', 'action' => 'index')) ?></li>                                            
                                                    <li class="divider"></li>
                                                    <li><?php echo $this->Html->link('Provincias', array('controller' => 'provinces', 'action' => 'index')) ?></li>
                                                    <li><?php echo $this->Html->link('Localidades', array('controller' => 'localities', 'action' => 'index')) ?></li>
                                                    <li><?php echo $this->Html->link('Tesauro', array('controller' => 'locality_thesaurus', 'action' => 'index')) ?></li>
                                                    <li class="divider"></li>
                                                    <li><?php echo $this->Html->link('Testimonios', array('controller' => 'testimonials', 'action' => 'index')) ?></li>
                                                </ul>
                                            </li>
                                            
                                            <?php if($userRole === 'admin'):?>
                                            <li class="dropdown-submenu">
                                                <a tabindex="-1" href="#">Ver</a>
                                                <ul class="dropdown-menu">
                                                    <li><?php echo $this->Html->link('Viajes Pendientes (Todos)', array('controller' => 'travels', 'action' => 'all_pending')) ?></li>
                                                    <li class="divider"></li>
                                                    <li><?php echo $this->Html->link('Interacciones de Usuarios', array('controller' => 'user_interactions', 'action' => 'view_filtered/all'))?></li>
                                                    <li><?php echo $this->Html->link(__('Urls Compartidas'), array('controller' => 'url_invitations', 'action'=>'index'))?></li> 
                                                    <li class="divider"></li>
                                                    <li><?php echo $this->Html->link('Dashboard', array('controller' => 'metrics', 'action' => 'dashboard'));?></li>                                                     
                                                </ul>
                                            </li>
                                            
                                            <li class="dropdown-submenu">
                                                <a tabindex="-1" href="#">Operaciones</a>
                                                <ul class="dropdown-menu">
                                                    <li><?php echo $this->Html->link('Reglas de operadores', array('controller' => 'op_action_rules', 'action'=>'index')) ?></li>
                                                </ul>
                                            </li>
                                            
                                            <li class="divider"></li>
                                            <li class="dropdown-submenu">
                                                <a tabindex="-1" href="#">Sistema</a>
                                                <ul class="dropdown-menu">
                                                    <li><?php echo $this->Html->link('Email Queue', array('controller' => 'email_queues', 'action' => 'index')) ?></li>
                                                    <li class="divider"></li>
                                                    <li><?php echo $this->Html->link('Datos Archivados', array('controller' => 'driver_traveler_conversations', 'action' => 'archive_state'));?></li>
                                                    
                                                    <li class="dropdown-submenu">
                                                        <a tabindex="-1" href="#">Logs</a>
                                                        <ul class="dropdown-menu">
                                                            <li><?php echo $this->Html->link('Info Choferes', array('controller' => 'admins', 'action' => 'view_log/info_choferes')) ?></li>
                                                            <li><?php echo $this->Html->link('Viajes Fallidos', array('controller' => 'admins', 'action' => 'view_log/travels_failed')) ?></li>
                                                            <li><?php echo $this->Html->link('Conversaciones', array('controller' => 'admins', 'action' => 'view_log/conversations')) ?></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <?php endif?>
                                            
                                            <li class="divider"></li>
                                            <li class="dropdown-submenu">
                                                <a tabindex="-1" href="#">Pruebas</a>
                                                <ul class="dropdown-menu">
                                                    <li><?php echo $this->Html->link('Solicitar viaje', array('controller' => 'travels', 'action' => 'add'));?></li> 
                                                    <li><?php echo $this->Html->link('Mis Anuncios', array('controller' => 'travels', 'action' => 'index'));?></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                
                                <li> <?php echo $this->element('form_search_user_travels')?> </li>

                            <?php endif?>

                            <?php if($userRole === 'regular' || $userRole === 'tester') :?>
                                <li><?php echo $this->Html->link(__('Mis Anuncios'), array('controller' => 'travels', 'action' => 'index'), array('class' => 'nav-link', 'escape'=>false));?></li>
                                <li class="divider-vertical"></li>
                                <li><?php echo $this->Html->link(__('Solicitar viaje'), array('controller' => 'travels', 'action' => 'add'), array('class' => 'nav-link', 'escape'=>false));?></li> 
                            <?php endif;?>
                                    
                        <?php else: ?>
                            <li><?php echo $this->Html->link('<i class="glyphicon glyphicon-home"></i> '.__('Inicio'), '/'.SessionComponent::read('Config.language'), array('class' => 'nav-link', 'escape'=>false));?></li>
                        <?php endif;?>            
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <?php if ($userLoggedIn): ?>
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link">
                                    <?php echo $pretty_user_name;?>
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><?php echo $this->Html->link(__('Perfil'), array('controller' => 'users', 'action' => 'profile')) ?></li>
                                    <li class="divider"></li>
                                    <?php if($userRole  == 'operator'):?><li><?php echo $this->Html->link(__('Operaciones'), array('controller' => 'users', 'action' => 'operations')) ?></li><li class="divider"></li><?php endif?>
                                    <li><?php echo $this->Html->link(__('Salir'), array('controller' => 'users', 'action' => 'logout')) ?></li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li>
                                <?php echo $this->Html->link(__('Entrar'), array('controller' => 'users', 'action' => 'login'), array('class' => 'nav-link', 'rel'=>'nofollow')) ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link(__('Registrarse'), array('controller' => 'users', 'action' => 'register'), array('class' => 'nav-link', 'rel'=>'nofollow')) ?>
                            </li>
                        <?php endif ?>

                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>
        </div>
            
            
            <?php echo $this->Session->flash('auth'); ?>

            <div id="content" class="container-fluid">
                <?php echo $this->Session->flash(); ?>
                <?php echo $this->fetch('content'); ?>
                
                <?php if( ROOT != 'C:\wamp\www\yotellevo' && (!$userLoggedIn || $userRole === 'regular') ):?>
                    <!-- 1FreeCounter -->
  
                    <script language="JavaScript">
                    var data = '&r=' + escape(document.referrer)
                        + '&n=' + escape(navigator.userAgent)
                        + '&p=' + escape(navigator.userAgent)
                        + '&g=' + escape(document.location.href);

                    if (navigator.userAgent.substring(0,1)>'3')
                    data = data + '&sd=' + screen.colorDepth 
                        + '&sw=' + escape(screen.width+'x'+screen.height);

                    document.write('<a href="http://www.1freecounter.com/stats.php?i=109722" target=\"_blank\" >');
                    document.write('<img alt="Free Counter" border=0 hspace=0 '+'vspace=0 src="http://www.1freecounter.com/counter.php?i=109722' + data + '">');
                    document.write('</a>');
                    </script>
                    
                    <!-- Google Analytics -->
                    <script>
                    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

                    ga('create', 'UA-60694533-1', 'auto');
                    ga('send', 'pageview');
                    </script>

                <?php endif;?>               
                
            </div>

            <div id="footer">
                <div class="container-fluid">
                    <?php echo $this->element('footer')?>
                </div>
            </div>
        </div>
    </body>
</html>