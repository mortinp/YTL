<?php App::uses('User', 'Model')?>

<?php
$userLoggedIn = AuthComponent::user('id') ? true : false;

if($userLoggedIn) {
    $user = AuthComponent::user();
    $userRole = $user['role'];
    $pretty_user_name = User::prettyName($user, true);
}
?>
<!DOCTYPE html>
<html >
    <head>

        <!-- Site made with Mobirise Website Builder v4.8.6, https://mobirise.com -->
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="generator" content="Mobirise v4.8.6, mobirise.com">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
        <link rel="shortcut icon" href="/assets/images/favicon.png" type="image/x-icon">
        <?php
        $title = __d('driver_profile', '%s, chofer en %s, Cuba', $profile['DriverProfile']['driver_name'], $profile['Province']['name']) . ' - ' . __d('driver_profile', 'Auto hasta %s pax', $profile['Driver']['max_people_count']);
        if ($profile['Driver']['has_air_conditioner']) $title .= ' ' . __d('driver_profile', 'con aire acondicionado');

        $description = __d('driver_profile', 'Contacta a %s para acordar tus recorridos en Cuba. Recibe una oferta de precio directamente de él y decide si te gustaría contratarlo.', Driver::shortenName($profile['DriverProfile']['driver_name']));
        ?>
        <title><?php echo $title . ' | YoTeLlevo' ?></title>
        <meta name="description" content="<?php echo $description ?>"/>
        
        <!-- FACEBOOK SHARE -->        
        <meta property="og:title" content="<?php echo substr($title, 0, 90)?>">
        <?php if($profile['DriverProfile']['featured_img_url'] != null):?>
        <meta property="og:image" content="<?php echo $profile['DriverProfile']['featured_img_url']?>">
        <?php endif?>
        <meta property="og:description" content="<?php echo $description?>">

        <?php
        // CSS
        $this->Html->css('web/assets/mobirise-icons/mobirise-icons', array('inline' => false));
        $this->Html->css('tether/tether.min', array('inline' => false));
        $this->Html->css('bootstrap/css/bootstrap.min', array('inline' => false));
        $this->Html->css('bootstrap/css/bootstrap-grid.min', array('inline' => false));
        $this->Html->css('bootstrap/css/bootstrap-reboot.min', array('inline' => false));
        $this->Html->css('dropdown/css/style', array('inline' => false));
        $this->Html->css('socicon/css/styles', array('inline' => false));
        $this->Html->css('theme/css/style', array('inline' => false));
        $this->Html->css('gallery/style', array('inline' => false));
        $this->Html->css('mobirise/css/mbr-additional', array('inline' => false));

        echo $this->fetch('css');
        ?>
        
        <?php
        // CSS
        $this->Html->css('datepicker/css/datepicker', array('inline' => false));
        $this->Html->css('typeaheadjs/css/typeahead.js-bootstrap', array('inline' => false));
        $this->Html->css('font-awesome/css/font-awesome.min', array('inline' => false));

        echo $this->fetch('css');
        ?>
        
        <?php
        // Hay que cargar JQuery aqui arriba porque el ajax-load de los testimonios lo necesita
        $this->Html->script('web/assets/jquery/jquery.min', array('inline' => false));
        echo $this->fetch('script');
        ?>

    </head>
    <body>

        <?php echo $this->element('mobirise/menu-driver-profile') ?>

        <?php echo $this->fetch('content') ?>

        <?php echo $this->element('mobirise/footer') ?>

        <?php
        // $this->Html->script('web/assets/jquery/jquery.min', array('inline' => false)); // Ya JQuery esta cargado arriba
        $this->Html->script('popper/popper.min', array('inline' => false));
        $this->Html->script('tether/tether.min', array('inline' => false));
        $this->Html->script('bootstrap/js/bootstrap.min', array('inline' => false));
        $this->Html->script('smoothscroll/smooth-scroll', array('inline' => false));
        $this->Html->script('dropdown/js/script.min', array('inline' => false));
        $this->Html->script('touchswipe/jquery.touch-swipe.min', array('inline' => false));
        $this->Html->script('masonry/masonry.pkgd.min', array('inline' => false));
        $this->Html->script('imagesloaded/imagesloaded.pkgd.min', array('inline' => false));
        $this->Html->script('bootstrapcarouselswipe/bootstrap-carousel-swipe', array('inline' => false));
        $this->Html->script('vimeoplayer/jquery.mb.vimeo_player', array('inline' => false));
        $this->Html->script('sociallikes/social-likes', array('inline' => false));
        $this->Html->script('theme/js/script', array('inline' => false));
        $this->Html->script('slidervideo/script', array('inline' => false));
        $this->Html->script('gallery/player.min', array('inline' => false));
        $this->Html->script('gallery/script', array('inline' => false));
        //$this->Html->script('formoid/formoid.min', array('inline' => false));
        ?>
        
        <?php

        $this->Html->script('datepicker/js/datepicker', array('inline' => false));

        $this->Html->script('jquery-validation-1.10.0/dist/jquery.validate.min', array('inline' => false));
        if(Configure::read('Config.language') != 'en') $this->Html->script('jquery-validation-1.10.0/localization/messages_'.Configure::read('Config.language'), array('inline' => false));

        echo $this->fetch('script');

        ?>
        
        <script type="text/javascript">    
            $(document).ready(function() {        
                $('.datepicker').datepicker({
                    format: "dd/mm/yyyy",
                    language: '<?php echo Configure::read('Config.language')?>',
                    startDate: 'today',
                    todayBtn: "linked",
                    autoclose: true,
                    todayHighlight: true
                });

                $('#CDirectForm').validate({
                    wrapper: 'div',
                    errorClass: 'text-danger',
                    errorElement: 'div'
                });  


                $('#CDirectForm').submit(function() {
                    if (!$(this).valid()) return false;

                    //$('#TravelForm :input').prop('disabled', true);
                    //$('#TravelFormDiv').prop('disabled', true);

                    $('#CDirectSubmit').attr('disabled', true);
                    $('#CDirectSubmit').val('<?php echo __d('mobirise/default', 'Espera')?> ...');
                });
            })
        </script>

        <script type="text/javascript">
            //<![CDATA[
            function get_form( element )
            {
                while( element )
                {
                    element = element.parentNode
                    if( element.tagName.toLowerCase() == "form" ) {
                        return element
                    }
                }
                return 0; //error: no form found in ancestors
            }
            //]]>
        </script>
        
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

    </body>
</html>