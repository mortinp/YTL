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
  <title><?php echo $page_title." | YoTeLlevo" ?></title>
  <meta name="description" content="<?php echo $page_description?>"/>
  
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
    $this->Html->css('font-awesome/css/font-awesome.min', array('inline' => false));
    
    echo $this->fetch('css');
  ?>
  
</head>
<body>

<?php echo $this->element('mobirise/menu')?>

<?php echo $this->fetch('content')?>

<?php echo $this->element('mobirise/footer')?>

<?php
$this->Html->script('web/assets/jquery/jquery.min', array('inline' => false));
$this->Html->script('popper/popper.min', array('inline' => false));
$this->Html->script('tether/tether.min', array('inline' => false));

$this->Html->script('bootstrap/js/bootstrap.min', array('inline' => false));
//$this->Html->script('smoothscroll/smooth-scroll', array('inline' => false));
$this->Html->script('dropdown/js/script.min', array('inline' => false));
$this->Html->script('touchswipe/jquery.touch-swipe.min', array('inline' => false));
$this->Html->script('bootstrapcarouselswipe/bootstrap-carousel-swipe', array('inline' => false));
$this->Html->script('mbr-clients-slider/mbr-clients-slider', array('inline' => false));
$this->Html->script('sociallikes/social-likes', array('inline' => false));
$this->Html->script('theme/js/script', array('inline' => false));
?>
    
<?php

$this->Html->script('datepicker/js/datepicker', array('inline' => false));

$this->Html->script('jquery-validation-1.10.0/dist/jquery.validate.min', array('inline' => false));
if(Configure::read('Config.language') != 'en') $this->Html->script('jquery-validation-1.10.0/localization/messages_'.Configure::read('Config.language'), array('inline' => false));

$this->Html->script('typeaheadjs/js/typeahead-martin', array('inline' => false));

$this->Js->set('localities', $localities);
echo $this->Js->writeBuffer(array('inline' => false));

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
        
        $('#TravelForm').validate({
            wrapper: 'div',
            errorClass: 'text-danger',
            errorElement: 'div'
        });  
        
        
        $('#TravelForm').submit(function() {
            if (!$(this).valid()) return false;

            //$('#TravelForm :input').prop('disabled', true);
            //$('#TravelFormDiv').prop('disabled', true);

            $('#TravelSubmit').attr('disabled', true);
            $('#TravelSubmit').val('<?php echo __d('mobirise/default', 'Espera')?> ...');
        });
    })
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('input.locality-typeahead').typeahead({
            valueKey: 'name',
            local: window.app.localities,
            limit: 20
        })/*.on('typeahead:selected', function(event, datum) {
            
        })*/;
        
        $('input.tt-hint').addClass('form-control');
        $('.twitter-typeahead').css('display', 'block');
    });

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