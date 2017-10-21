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
                            <li><?php echo $this->Html->link(__('Ir al Inicio'), '/'.SessionComponent::read('Config.language'), array('class' => 'nav-link', 'escape'=>false));?></li>
                            <?php echo $this->Html->link('<button type="button" class="btn btn-info navbar-btn">'.__d('shared_travels', 'VER TRANSFERS DISPONIBLES').'</button>', array('controller'=>'shared-rides', 'action'=>'home#transfers-available'), array('escape'=>false, 'style'=>'padding:0px;padding-right:10px'))?>
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
        
        <script type="text/javascript">
            function goTo(id, time, offset) {
                $('html, body').animate({
                    scrollTop: $('#' + id).offset().top + offset
                }, time);
            };
            
            <?php if(isset($this->request->query['highlight'])):?>
                $(document).ready(function() {
                    goTo('<?php echo $this->request->query['highlight']?>', 500, -70);
                });
            <?php endif?>
         </script>
        
    </body>
</html>