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
  <link rel="stylesheet" href="assets/web/assets/mobirise-icons/mobirise-icons.css">
  <link rel="stylesheet" href="assets/tether/tether.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-grid.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-reboot.min.css">
  <link rel="stylesheet" href="assets/dropdown/css/style.css">
  <link rel="stylesheet" href="assets/socicon/css/styles.css">
  <link rel="stylesheet" href="assets/theme/css/style.css">
  <link rel="stylesheet" href="assets/mobirise/css/mbr-additional.css" type="text/css">
  
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


  <script src="assets/web/assets/jquery/jquery.min.js"></script>
  <script src="assets/popper/popper.min.js"></script>
  <script src="assets/tether/tether.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/smoothscroll/smooth-scroll.js"></script>
  <script src="assets/dropdown/js/script.min.js"></script>
  <script src="assets/touchswipe/jquery.touch-swipe.min.js"></script>
  <script src="assets/bootstrapcarouselswipe/bootstrap-carousel-swipe.js"></script>
  <script src="assets/mbr-clients-slider/mbr-clients-slider.js"></script>
  <script src="assets/sociallikes/social-likes.js"></script>
  <script src="assets/theme/js/script.js"></script>
  <!--<script src="assets/formoid/formoid.min.js"></script>-->
  
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