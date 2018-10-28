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
  
  
</body>
</html>