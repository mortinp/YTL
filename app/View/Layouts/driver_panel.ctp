<?php

App::uses('Travel', 'Model')?>
<?php App::uses('DriverTravel', 'Model')?>
<?php App::uses('User', 'Model')?>


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
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title><?php echo "Panel de Choferes | YoTeLlevo" ?></title>
        <meta name="description" content="<?php echo $page_description?>"/>

        <style type="text/css">

            /*#navbar {
                background: linear-gradient(45deg, rgb(85, 180, 216), rgb(85, 180, 212));
            } */       
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
            
            #profile-description img {
                margin-top: 20px;
                margin-bottom: 20px;
            }
            
      

            /* Back to top button */
            .back-to-top {
                position: fixed;
                display: none;
                background: rgb(85, 180, 212);
                color: #fff;
                padding: 2px 20px 8px 20px;
                font-size: 16px;
                border-radius: 4px 4px 0 0;
                right: 5px;
                bottom: 10px;
                transition: none;
            }

            .back-to-top:focus {
                background: linear-gradient(45deg, #1de099, #1dc8cd);
                color: #fff;
                outline: none;
            }

            .back-to-top:hover {
                background: #1dc8cd;
                color: #fff;
            }


            /*--------------------------------------------------------------
            # Header
            --------------------------------------------------------------*/
            #header {
                padding: 30px 0;
                height: 92px;
                position: fixed;
                left: 0;
                top: 0;
                right: 0;
                transition: all 0.5s;
                z-index: 997;
            }

           
            #header.header-fixed {                
                padding: 20px 0;
                height: 72px;
                transition: all 0.5s;
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
            $(document).ready(function () {

                $.each($('.info'), function (pos, obj) {
                    var placement = 'bottom';
                    if ($(obj).attr('data-placement') !== undefined)
                        placement = $(obj).attr('data-placement');
                    $(obj).tooltip({placement: placement, html: true});
                });

                //$('.info').tooltip({placement:'bottom', html:true});

                // Header fixed and Back to top button
                $(window).scroll(function () {
                    if ($(this).scrollTop() > 80 ) {
                        $('.back-to-top').fadeIn('slow');
                        $('#header').addClass('header-fixed');
                    } else {
                        $('.back-to-top').fadeOut('slow');
                        $('#header').removeClass('header-fixed');
                    }
                });
                $('.back-to-top').click(function () {
                    $('html, body').animate({
                        scrollTop: 0
                    }, 1500);
                    return false;
                });



            })
        </script>
    </head>
    <body>       
            

<div id="container">
        <?php echo $this->Session->flash('auth'); ?>
            <div id="content" class="container">
                <div class="row" style="margin-top: 9em"></div>
                
                <div class="row">
                    <div class="col-md-9">
                <?php echo $this->Session->flash(); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">                       
                <?php echo $this->fetch('content'); ?>
                    </div>
                </div>
            </div>
           
                <?php if( ROOT != 'C:\wamp\www\yotellevo' && (!$userLoggedIn || $userRole === 'regular') ):?>
            <!-- 1FreeCounter -->

            <script language="JavaScript">
                var data = '&r=' + escape(document.referrer)
                        + '&n=' + escape(navigator.userAgent)
                        + '&p=' + escape(navigator.userAgent)
                        + '&g=' + escape(document.location.href);

                if (navigator.userAgent.substring(0, 1) > '3')
                    data = data + '&sd=' + screen.colorDepth
                            + '&sw=' + escape(screen.width + 'x' + screen.height);

                document.write('<a href="http://www.1freecounter.com/stats.php?i=109722" target=\"_blank\" >');
                document.write('<img alt="Free Counter" border=0 hspace=0 ' + 'vspace=0 src="http://www.1freecounter.com/counter.php?i=109722' + data + '">');
                document.write('</a>');
            </script>

            <!-- Google Analytics -->
            <script>
                (function (i, s, o, g, r, a, m) {
                    i['GoogleAnalyticsObject'] = r;
                    i[r] = i[r] || function () {
                        (i[r].q = i[r].q || []).push(arguments)
                    }, i[r].l = 1 * new Date();
                    a = s.createElement(o),
                            m = s.getElementsByTagName(o)[0];
                    a.async = 1;
                    a.src = g;
                    m.parentNode.insertBefore(a, m)
                })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

                ga('create', 'UA-60694533-1', 'auto');
                ga('send', 'pageview');
            </script>

                <?php endif;?>            

            
            <div id="footer">
                <div class="container-fluid">
                    <?php echo $this->element('footer')?>
                </div>
            </div>
            
            
        </div>        
         
        <a href="#" class="back-to-top"><i class="glyphicon glyphicon-chevron-up"></i></a>

        <script type="text/javascript">
            function goTo(id, time, offset) {
                $('html, body').animate({
                    scrollTop: $('#' + id).offset().top + offset
                }, time);
            }
            ;

            <?php if(isset($this->request->query['highlight'])):?>
            $(document).ready(function () {
                goTo('<?php echo $this->request->query['highlight']?>', 500, -70);
            });
            <?php endif?>
        </script>

    </body>
</html>