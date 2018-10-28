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
  <meta name="description" content="<?php echo $page_description?>"/>
  <title><?php echo $page_title." | YoTeLlevo" ?></title>
  
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
    
    echo $this->fetch('css');
  ?>
  
</head>
<body>

<?php echo $this->element('mobirise/menu-transition')?>

<?php echo $this->fetch('content')?>

<?php echo $this->element('mobirise/footer')?>

<?php

$this->Html->script('web/assets/jquery/jquery.min', array('inline' => false));
$this->Html->script('popper/popper.min', array('inline' => false));
$this->Html->script('tether/tether.min', array('inline' => false));
$this->Html->script('bootstrap/js/bootstrap.min', array('inline' => false));
$this->Html->script('smoothscroll/smooth-scroll', array('inline' => false));
$this->Html->script('dropdown/js/script.min', array('inline' => false));

$this->Html->script('theme/js/script', array('inline' => false));

echo $this->fetch('script');

?>
    
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
  
  
</body>
</html>