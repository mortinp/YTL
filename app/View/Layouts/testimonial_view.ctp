<?php App::uses('User', 'Model')?>
<?php App::uses('Driver', 'Model')?>

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
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#">
    <head>        
        <?php echo $this->Html->charset(); ?>
        <?php
        $testimonial = $data['Testimonial'];
        $profile = $data['Driver']['DriverProfile'];
        
        $title = str_replace('%driver', $profile['driver_name'], $page_title);
        $description = str_replace('%author', $testimonial['author'], $page_description);
        $description = str_replace('%driver', $profile['driver_name'], $description);
        ?>
        <title><?php echo $title.' | YoTeLlevo' ?></title>
        <meta name="description" content="<?php echo $description?>"/>
        
        <!-- FACEBOOK SHARE -->
        <?php
        $fbImgUrl = '';
        $fullBaseUrl = Configure::read('App.fullBaseUrl');
        if(Configure::read('debug') > 0) $fullBaseUrl .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien
        
        if ($testimonial['image_filepath']) $fbImgUrl = $fullBaseUrl.'/'.str_replace('\\', '/', $testimonial['image_filepath']);
        else if ($profile['featured_img_url']) $fbImgUrl = $profile['featured_img_url'];
        else $fbImgUrl = $fullBaseUrl.'/'.str_replace('\\', '/', $profile['avatar_filepath']);
        ?>
        <meta property="og:title" content="<?php echo substr(__d('testimonials', 'Testimonio de %s sobre su chofer en Cuba, %s', $testimonial['author'], $profile['driver_name']), 0, 90)?>">
        <meta property="og:image" content="<?php echo $fbImgUrl?>">
        <meta property="og:description" content="<?php echo substr($testimonial['text'], 0, 300)?>...">
        
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
            #navbar #nav .navbar-btn{
                margin-left:15px;
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
                        <a class="navbar-brand" href="#!">
                            <big>Yo</big>Te<big>Llevo</big>
                        </a>
                        <div class="pull-left navbar-brand">
                            <?php $lang = SessionComponent::read('app.lang');?>
                            <?php if($lang != null && $lang == 'en'):?>
                                <?php echo $this->Html->link($this->Html->image('Spain.png'), $lang_changed_url, array('class' => 'nav-link', 'title'=>'Traducir al Español', 'escape'=>false, 'style'=>'text-decoration:none')) ?>
                            <?php else:?>
                                <?php echo $this->Html->link($this->Html->image('UK.png'), $lang_changed_url, array('class' => 'nav-link', 'title'=>'Translate to English', 'escape'=>false, 'style'=>'text-decoration:none')) ?>
                            <?php endif;?>
                        </div>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <ul class="nav navbar-nav">
                            <?php if ($userLoggedIn) :?>
                            
                                <?php if($userRole === 'regular' || $userRole === 'admin' || $userRole === 'tester') :?>
                                    
                                <?php endif;?>
                                    
                            <?php else: ?>
                                <li><?php echo $this->Html->link(__('Ir al Inicio'), '/'.SessionComponent::read('Config.language'), array('class' => 'nav-link', 'escape'=>false));?></li>
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
                                        <li><?php echo $this->Html->link(__('Salir'), array('controller' => 'users', 'action' => 'logout')) ?></li>
                                    </ul>
                                </li>
                            <?php else: ?>
                                <li>
                                    <?php echo $this->Html->link(__('Entrar'), array('controller' => 'users', 'action' => 'login'), array('class' => 'nav-link')) ?>
                                </li>
                                <li>
                                    <?php echo $this->Html->link(__('Registrarse'), array('controller' => 'users', 'action' => 'register'), array('class' => 'nav-link')) ?>
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
                
                <?php if( ROOT != 'C:\wamp\www\yotellevo' && (!$userLoggedIn || $userRole === 'regular') ):?>
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

                    <!-- End 1FreeCounter.com code -->
                    
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