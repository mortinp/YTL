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
  ?>
  <link rel="canonical" href="<?php echo $this->Html->url($url, true)?>"/>
  
  <?php
    $page_title = __d('meta', 'Taxi barato en Cuba | Descuento hasta 50%');
    $page_description = __d('meta', 'Nuestros choferes hacen ofertas de 50% de descuento en algunas ocasiones. Nosotros las listamos aquí y tú puedes reservarlas. Encuentra estas promociones y ahorra dinero.');
  ?>
  <link rel="shortcut icon" href="/assets/images/favicon.png" type="image/x-icon">
  <title><?php echo $page_title." | YoTeLlevo" ?></title>
  <meta name="description" content="<?php echo $page_description?>"/>
  
  <!-- TWITTER SHARE -->   
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?php echo substr($page_title, 0, 70)?>">
  <meta name="twitter:description" content="<?php echo $page_description?>">
  <meta name="twitter:site" content="@yotellevocuba">
  <meta name="twitter:creator" content="@yotellevocuba">
  <meta name="twitter:image:src" content="/assets/images/1525113306-ismel-kimara-jpg-2000x1333.jpg">
  
  <!-- FACEBOOK SHARE -->        
  <meta property="og:title" content="<?php echo substr($page_title, 0, 90)?>">
  <meta property="og:image" content="/assets/images/1525113306-ismel-kimara-jpg-2000x1333.jpg">
  <meta property="og:description" content="<?php echo $page_description?>">
      
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

$this->Html->css('mobirise/css/mbr-additional', array('inline' => false));

$this->Html->css('font-awesome/css/font-awesome.min', array('inline' => false));
?>
  
<?php
// CSS
$this->Html->css('datepicker/css/datepicker', array('inline' => false));
$this->Html->css('typeaheadjs/css/typeahead.js-bootstrap', array('inline' => false));

echo $this->fetch('css');
?>
  
  
  
</head>
<body>
<?php echo $this->element('covid19/ribbon')?>

<?php echo $this->element('mobirise/menu', array('cta'=>__d('mobirise/cheap_taxi', 'Ver ofertas disponibles')))?>

<?php echo $this->fetch('content')?>
<?php echo $this->element('addon_picko_linker')?>

<?php echo $this->element('mobirise/footer1')?>

<?php
$this->Html->script('web/assets/jquery/jquery.min', array('inline' => false));
$this->Html->script('popper/popper.min', array('inline' => false));
$this->Html->script('tether/tether.min', array('inline' => false));

$this->Html->script('bootstrap/js/bootstrap.min', array('inline' => false));
$this->Html->script('dropdown/js/script.min', array('inline' => false));
$this->Html->script('touchswipe/jquery.touch-swipe.min', array('inline' => false));
$this->Html->script('bootstrapcarouselswipe/bootstrap-carousel-swipe', array('inline' => false));
$this->Html->script('mbr-clients-slider/mbr-clients-slider', array('inline' => false));
$this->Html->script('sociallikes/social-likes', array('inline' => false));
$this->Html->script('parallax/jarallax.min', array('inline' => false));
$this->Html->script('theme/js/script', array('inline' => false));

echo $this->fetch('script');
?>

<script type="text/javascript">
    
    $(document).ready(function() {   
        /*Popover de picko linker */
        picko = $('.picko-linker');
        if(picko !== null) {
            setTimeout(function(){       
                picko.css("visibility","visible");        
            }, 45000);
            picko.find('.dismiss').click(function () {       
                picko.animate({opacity:'hide', heigh:'hide'},'slow');        
            });
        }
    })
</script>

<?php if( ROOT != 'C:\wamp\www\yotellevo' && (!$isLoggedIn || $role === 'regular') ):?>
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