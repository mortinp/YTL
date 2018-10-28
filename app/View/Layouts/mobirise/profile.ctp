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

    </body>
</html>