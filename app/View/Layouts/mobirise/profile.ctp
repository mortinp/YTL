<?php

App::uses('User', 'Model')?>
<?php
$userLoggedIn = AuthComponent::user('id') ? true : false;

if($userLoggedIn) {
    $user = AuthComponent::user();
    $userRole = $user['role'];
    $pretty_user_name = User::prettyName($user, true);
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#">
<head>

    <!-- Site made with Mobirise Website Builder v4.8.6, https://mobirise.com -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="generator" content="Mobirise v4.8.6, mobirise.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">

    <?php
        $url = $this->request['pass'];
        $url = array_merge($url, $this->request['named']);
        $url['language'] = Configure::read('Config.language');
        $url['reviews'] = 20;
    ?>
    <link rel="canonical" href="<?php echo $this->Html->url($url, true) ?>"/>
    <link rel="shortcut icon" href="/assets/images/favicon.png" type="image/x-icon">

    <?php
    $title = __d('mobirise/driver_profile', 'Taxi en %s, Cuba: %s', $profile['Province']['name'], $profile['DriverProfile']['driver_name']);

    $description = __d('mobirise/driver_profile', 'Taxi hasta %s capacidades', $profile['Driver']['max_people_count']);
    if ($profile['Driver']['has_air_conditioner']) $description .= ' ' . __d('mobirise/driver_profile', 'con aire acondicionado');
    $description .= '. '.__d('mobirise/driver_profile', 'Contacta a %s para acordar traslados en Cuba.', Driver::shortenName($profile['DriverProfile']['driver_name']));
    
    //$description = __d('driver_profile', 'Contacta a %s para acordar tus recorridos en Cuba. Recibe una oferta de precio directamente de él y decide si te gustaría contratarlo.', Driver::shortenName($profile['DriverProfile']['driver_name']));
    ?>
    <title><?php echo $title . ' | YoTeLlevo' ?></title>
    <meta name="description" content="<?php echo $description ?>"/>

    <!-- SOCIAL SHARE -->
    <?php
    $socialTitle = $title;
    $socialDescription = $description;
    $socialImageUrl = $profile['DriverProfile']['featured_img_url'];
    ?>
    <?php if(isset($discount)):?>
        <?php
        $socialTitle = __d('mobirise/cheap_taxi', 'Taxi privado %s > %s por %s. Oferta de taxi económico en Cuba.', 
                $discount['DiscountRide']['origin'], 
                $discount['DiscountRide']['destination'],
                '$'.$discount['DiscountRide']['price']);
        $socialDescription = __d('mobirise/cheap_taxi', '%s oferta taxi privado %s > %s por %s el próximo %s. Mira los detalles de esta oferta económica en su perfil.',
                $profile['DriverProfile']['driver_name'],
                $discount['DiscountRide']['origin'], 
                $discount['DiscountRide']['destination'],
                '$'.$discount['DiscountRide']['price'],
                TimeUtil::prettyDateShort($discount['DiscountRide']['date'], false));
        ?>
    <?php ?>
    <?php elseif($this->request->query('see-review')):?>
        <?php
        $socialTitle = __d('testimonials', 'Testimonio de %s sobre su chofer en Cuba, %s', $highlighted['Testimonial']['author'], $profile['DriverProfile']['driver_name']);
        $socialDescription = $highlighted['Testimonial']['text'];
        
        if ($highlighted['Testimonial']['image_filepath']) $socialImageUrl = PathUtil::getFullPath($highlighted['Testimonial']['image_filepath']);
        else if ($profile['DriverProfile']['featured_img_url']) $socialImageUrl = $profile['DriverProfile']['featured_img_url'];
        else $socialImageUrl = PathUtil::getFullPath($profile['DriverProfile']['avatar_filepath']);
        ?>
    <?php endif?>
    
    <?php
    $currentFullUrl             = $this->request['pass'];
    $currentFullUrl             = array_merge($currentFullUrl, $this->request['named']);
    $currentFullUrl['?']        = $this->request->query;
    $currentFullUrl['language'] = Configure::read('Config.language');
    $currentFullUrl['base'] = false;
    ?>
    
    <!-- FACEBOOK SHARE -->  
    <meta property="og:title" content="<?php echo substr($socialTitle, 0, 120)?>">
    <meta property="og:description" content="<?php echo substr($socialDescription, 0, 300)?>">
    <meta property="og:image" content="<?php echo $socialImageUrl?>">
    <meta property="og:url" content="<?php echo $this->Html->url($currentFullUrl, true) ?>" />
    
    <!-- TWITTER SHARE -->   
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo substr($socialTitle, 0, 70)?>">
    <meta name="twitter:description" content="<?php echo substr($socialDescription, 0, 200)?>">
    <meta name="twitter:site" content="@yotellevocuba">
    <meta name="twitter:creator" content="@yotellevocuba">
    <meta name="twitter:image:src" content="<?php echo $socialImageUrl?>">
    
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

    <?php echo $this->element('mobirise/footer1') ?>

    <?php
    // $this->Html->script('web/assets/jquery/jquery.min', array('inline' => false)); // Ya JQuery esta cargado arriba
    $this->Html->script('popper/popper.min', array('inline' => false));
    $this->Html->script('tether/tether.min', array('inline' => false));
    $this->Html->script('bootstrap/js/bootstrap.min', array('inline' => false));
    //$this->Html->script('smoothscroll/smooth-scroll', array('inline' => false));
    $this->Html->script('dropdown/js/script.min', array('inline' => false));
    $this->Html->script('touchswipe/jquery.touch-swipe.min', array('inline' => false));
    $this->Html->script('masonry/masonry.pkgd.min', array('inline' => false));
    $this->Html->script('imagesloaded/imagesloaded.pkgd.min', array('inline' => false));
    $this->Html->script('bootstrapcarouselswipe/bootstrap-carousel-swipe', array('inline' => false));
    //$this->Html->script('vimeoplayer/jquery.mb.vimeo_player', array('inline' => false));
    $this->Html->script('sociallikes/social-likes', array('inline' => false));
    $this->Html->script('theme/js/script', array('inline' => false));
    $this->Html->script('slidervideo/script', array('inline' => false));
    $this->Html->script('gallery/player.min', array('inline' => false));
    $this->Html->script('gallery/script', array('inline' => false));
    $this->Html->script('theme/js/script', array('inline' => false));
    //$this->Html->script('formoid/formoid.min', array('inline' => false));
    ?>

    <?php

    $this->Html->script('datepicker/js/datepicker', array('inline' => false));

    $this->Html->script('jquery-validation-1.10.0/dist/jquery.validate.min', array('inline' => false));
    if(Configure::read('Config.language') != 'en') $this->Html->script('jquery-validation-1.10.0/localization/messages_'.Configure::read('Config.language'), array('inline' => false));

    echo $this->fetch('script');

    ?>

    <script type="text/javascript">
        $(document).ready(function () {            
            $('.datepicker').datepicker({
                format: "dd/mm/yyyy",
                language: '<?php echo Configure::read('Config.language')?>',
                startDate: 'today',
                todayBtn: "linked",
                autoclose: true,
                todayHighlight: true,
               
            });
   
      <?php if($this->request->query('discount')): ?>
            $('.datepicker').datepicker('setDate',pickervalue);
            goTo('<?php echo __d('mobirise/default', 'solicitar')?>', 500, 20);
            $("#DriverTravelerConversationResponseText").focus();
      <?php endif; ?>  
      /*Elementos para controlar el flujo de reserva de actividades*/
       <?php if($this->request->query('activity_offer')): ?>            
            goTo('<?php echo __d('mobirise/default', 'solicitar')?>', 500, 20);
            $("#DriverTravelerConversationResponseText").focus();
      <?php endif; ?>        
           
           

            $('#CDirectForm').validate({
                wrapper: 'div',
                errorClass: 'text-danger',
                errorElement: 'div'
            });


            $('#CDirectForm').submit(function () {
                if (!$(this).valid())
                    return false;

                //$('#TravelForm :input').prop('disabled', true);
                //$('#TravelFormDiv').prop('disabled', true);

                $('#CDirectSubmit').attr('disabled', true);
                $('#CDirectSubmit').val('<?php echo __d('mobirise/default', 'Espera')?> ...');
            });
        })
    </script>

    <script type="text/javascript">
        //<![CDATA[
        function get_form(element)
        {
            while (element)
            {
                element = element.parentNode
                if (element.tagName.toLowerCase() == "form") {
                    return element
                }
            }
            return 0; //error: no form found in ancestors
        }
        //]]>
    </script>
    
    <!--Getting a given review for highlight :) -->
    <script type="text/javascript">
        function goTo(id, time, offset) {
            $('html, body').animate({
                scrollTop: $('#' + id).offset().top + offset
            }, time);
        };

    <?php if($this->request->query('see-review')): ?>

        $(document).ready(function () {
            goTo('<?php echo $this->request->query['see-review']?>', 500, -70);
        });
    <?php endif; ?>

    </script>

    <?php if( ROOT != 'C:\wamp\www\yotellevo' && (!$userLoggedIn || $userRole === 'regular') ):?>
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
</body>
    
</html>