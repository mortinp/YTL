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
                color:white;
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
        $this->Html->css('home', array('inline' => false));
        
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
            
        <?php echo $this->Session->flash('auth'); ?>        
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

        <div id="footer">
            <div class="container-fluid">
                <?php echo $this->element('footer')?>
            </div>
        </div>
    </body>
</html>