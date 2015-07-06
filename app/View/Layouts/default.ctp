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
        <title><?php echo "Cuba - ".$page_title." | YoTeLlevo" ?></title>
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
            <div id="navbar" class="navbar navbar-default" role="navigation">
                <nav id="nav">
                <!-- Brand and toggle get grouped for better mobile display -->
                <!--<div class="container-fluid">-->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#app-navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                            <span class="white navbar-brand"><big>Yo</big>Te<big>Llevo</big></span>
                        <div class="pull-left navbar-brand">
                            <?php $lang = SessionComponent::read('app.lang');?>
                            <?php if($lang != null && $lang == 'en'):?>
                                <?php echo $this->Html->link($this->Html->image('Spain.png')/*.' Español'*/, array('controller' => 'lang', 'action' => 'setlang', 'es'), array('class' => 'nav-link', 'title'=>'Traducir al Español', 'escape'=>false, 'style'=>'text-decoration:none')) ?>
                            <?php else:?>
                                <?php echo $this->Html->link($this->Html->image('UK.png')/*.' English'*/, array('controller' => 'lang', 'action' => 'setlang', 'en'), array('class' => 'nav-link', 'title'=>'Translate to English', 'escape'=>false, 'style'=>'text-decoration:none')) ?>
                            <?php endif;?>
                        </div>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <ul class="nav navbar-nav">
                            <?php if ($isLoggedIn) :?>
                            
                                <?php if($role === 'regular' || $role === 'admin' || $role === 'tester') :?>
                                    <li><?php echo $this->Html->link(__('Mis Anuncios'), array('controller' => 'travels', 'action' => 'index'), array('class' => 'nav-link', 'escape'=>false));?></li>
                                    <li class="divider-vertical"></li>
                                    <li><?php echo $this->Html->link(__('Anunciar Viaje'), array('controller' => 'travels', 'action' => 'add'), array('class' => 'nav-link', 'escape'=>false));?></li> 
                                    
                                    <?php if($role === 'admin') :?>
                                    <li class="divider-vertical"></li>
                                    <li class="dropdown">
                                        <a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link">
                                            Administrar
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
                                                </ul>
                                            </li>
                                            <li class="dropdown-submenu">
                                                <a tabindex="-1" href="#">Ver</a>
                                                <ul class="dropdown-menu">
                                                    <li><?php echo $this->Html->link('Viajes (Todos)', array('controller' => 'travels', 'action' => 'all')) ?></li>
                                                    <li><?php echo $this->Html->link('Pendientes (Todos)', array('controller' => 'travels', 'action' => 'all_pending')) ?></li>
                                                    <li class="divider"></li>
                                                    <li><?php echo $this->Html->link('Email Queue', array('controller' => 'email_queues', 'action' => 'index')) ?></li>
                                                </ul>
                                            </li>
                                            <li class="dropdown-submenu">
                                                <a tabindex="-1" href="#">Logs</a>
                                                <ul class="dropdown-menu">
                                                    <li><?php echo $this->Html->link('Raw Emails', array('controller' => 'admins', 'action' => 'view_log/emails_raw')) ?></li>
                                                    <li><?php echo $this->Html->link('Info Requerida', array('controller' => 'admins', 'action' => 'view_log/info_requested')) ?></li>
                                                    <li><?php echo $this->Html->link('Viajes por Correo', array('controller' => 'admins', 'action' => 'view_log/travels_by_email')) ?></li>                                                    
                                                    <li><?php echo $this->Html->link('Conversaciones', array('controller' => 'admins', 'action' => 'view_log/conversations')) ?></li>
                                                    <li><?php echo $this->Html->link('Viajes Fallidos', array('controller' => 'admins', 'action' => 'view_log/travels_failed')) ?></li>
                                                </ul>
                                            </li>
                                            <li class="divider"></li>
                                            <li class="dropdown-submenu">
                                                <a tabindex="-1" href="#">Tests</a>
                                                <ul class="dropdown-menu">
                                                    <li><?php echo $this->Html->link('Ver Viajes Admins', array('controller' => 'travels', 'action' => 'all_admins')) ?></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <?php endif;?>
                                <?php endif;?>
                                    
                            <?php else: ?>
                                <li><?php echo $this->Html->link('<i class="glyphicon glyphicon-home"></i> '.__('Inicio'), '/', array('class' => 'nav-link', 'escape'=>false));?></li>
                            <?php endif;?>            
                        </ul>

                        <ul class="nav navbar-nav navbar-right">
                            <?php if ($isLoggedIn): ?>
                                <li class="dropdown">
                                    <a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link">
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
                                    <?php echo $this->Html->link(__('Entrar'), array('controller' => 'users', 'action' => 'login'), array('class' => 'nav-link', 'rel'=>'nofollow')) ?>
                                </li>
                                <li>
                                    <?php echo $this->Html->link(__('Registrarse'), array('controller' => 'users', 'action' => 'register'), array('class' => 'nav-link', 'rel'=>'nofollow')) ?>
                                </li>
                            <?php endif ?>

                        </ul>
                    </div><!-- /.navbar-collapse -->
                <!--</div>-->
                </nav>
            </div>
            
            
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

                    <!-- End 1FreeCounter.com code -->
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