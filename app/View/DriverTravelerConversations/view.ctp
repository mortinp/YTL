<?php
$driverName = 'el chofer'.' <small class="text-muted">('.$data['Driver']['username'].')</small>'?>
<?php $hasProfile = isset ($data['Driver']['DriverProfile']) && $data['Driver']['DriverProfile'] != null && !empty ($data['Driver']['DriverProfile'])?>
<?php if($hasProfile) :?>
    <?php
        $src = Configure::read('App.fullBaseUrl');//Esto para que la ruta a la imagen sea correcta
        if(Configure::read('debug') > 0) $src .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien
        $src .= '/'.str_replace('\\', '/', $data['Driver']['DriverProfile']['avatar_filepath']);
        
        $driverName = $data['Driver']['DriverProfile']['driver_name'].'</small>';
    ?>
<?php endif;?>
<?php $topPosition = 60?>
<!--Traido de Travels por el cambio de lugar del control de Cambio de Fechas-->
<?php $fechaCambiada = isset ($data['Travel']['original_date']) && $data['Travel']['original_date'] != null;?>
<style>
    /*
 *
 *	 This is style for skin config
 *	 Used in lateral menu
 *
*/

    /*.theme-config  a {
            color: #0c0b0b!important;
        }*/

    .theme-config {
        position: fixed;
        top: 110px;
        right: 0; 
        overflow: hidden;
        z-index: 40;
    }
    .theme-config-box {
        margin-right: -220px;
        position: relative;        
        transition-duration: 0.6s;

    }
    .theme-config-box.show {
        margin-right: 0;
    }
    .spin-icon {
        background:#06f;
        position: absolute;
        padding: 3px;
        border-radius: 20px 0 0 20px;
        font-size: 20px;
        top: 0;
        left: 0;	
        color: #fff;
        cursor: pointer;
        opacity: .8;
        height: 35px;
    }
    .skin-settings {
        width: 220px;
        margin-left: 40px;
        background-color: rgba(200, 219, 243, 0.6);
        /*box-shadow:  5px 1px 1px 2px rgba(0, 0, 0, 0.4);*/
        border-radius: 0 0 0 10px;


    }
    .skin-settings .title {
        background: #efefef;
        text-align: center;
        text-transform: uppercase;
        font-weight: 600;
        display: block;
        padding: 10px 15px;
        font-size: 12px;
    }
    .setings-item {
        padding: 10px 30px;
    }
    .setings-item.skin {
        text-align: center;
    }
    .setings-item .switch {
        float: right;
    }
    .skin-name a {
        text-transform: uppercase;
    }
    /*.setings-item a {
            color: #fff;
    }*/

    @media (min-width: 768px) {
        #page-wrapper {
            position: inherit;
            margin: 0 0 0 220px;
            min-height: 1200px;
        }
        .navbar-static-side {
            z-index: 2001;
            position: absolute;
            width: 220px;
        }
        .navbar-top-links .dropdown-messages,
        .navbar-top-links .dropdown-tasks,
        .navbar-top-links .dropdown-alerts {
            margin-left: auto;
        }
    }
    @media (max-width: 768px) {
        #page-wrapper {
            position: inherit;
            margin: 0 0 0 0;
            min-height: 1000px;
        }
        .body-small .navbar-static-side {
            display: none;
            z-index: 2001;
            position: absolute;
            width: 70px;
        }
        .body-small.mini-navbar .navbar-static-side {
            display: block;
        }
        .lock-word {
            display: none;
        }
        .navbar-form-custom {
            display: none;
        }
        .navbar-header {
            display: inline;
            float: left;
        }
        .sidebar-panel {
            z-index: 2;
            position: relative;
            width: auto;
            min-height: 100% !important;
        }
        .sidebar-content .wrapper {
            padding-right: 0;
            z-index: 1;
        }
        .fixed-sidebar.body-small .navbar-static-side {
            display: none;
            z-index: 2001;
            position: fixed;
            width: 220px;
        }
        .fixed-sidebar.body-small.mini-navbar .navbar-static-side {
            display: block;
        }
        .ibox-tools {
            float: none;
            text-align: right;
            display: block;
        }
        .navbar-static-side {
            display: none;
        }
        body:not(.mini-navbar) {
            -webkit-transition: background-color 500ms linear;
            -moz-transition: background-color 500ms linear;
            -o-transition: background-color 500ms linear;
            -ms-transition: background-color 500ms linear;
            transition: background-color 500ms linear;
            background-color: #ffffff;
        }
    }
    @media (max-width: 350px) {
        .timeline-item .date {
            text-align: left;
            width: 110px;
            position: relative;
            padding-top: 30px;
        }
        .timeline-item .date i {
            position: absolute;
            top: 0;
            left: 15px;
            padding: 5px;
            width: 30px;
            text-align: center;
            border: 1px solid #e7eaec;
            background: #f8f8f8;
        }
        .timeline-item .content {
            border-left: none;
            border-top: 1px solid #e7eaec;
            padding-top: 10px;
            min-height: 100px;
        }
        .nav.navbar-top-links li.dropdown {
            display: none;
        }
        .ibox-tools {
            float: none;
            text-align: left;
            display: inline-block;
        }
    }
    /* Only demo */
    @media (max-width: 1000px) {
        .welcome-message {
            display: none;
        }
    }
    @media print {
        nav.navbar-static-side {
            display: none;
        }
        body {
            overflow: visible !important;
        }
        #page-wrapper {
            margin: 0;
        }
        
    }
    
    /*Ocultar el panel superior*/
    #main-header {      
      transition: top 0.5s!important;
      display: block;
      background-color: white;
      position: fixed;
      z-index: 10;
      top: 45px
           
   }
    

</style>

<div class="theme-config">
    <div class="theme-config-box">
        <div class="spin-icon">
            <i id="box-menu" class="glyphicon glyphicon-chevron-left pull-left"></i><i class="glyphicon glyphicon-list pull-right"></i>
        </div>
        <div class="skin-settings">            
            <div class="setings-item">
                   <?php echo $this->element('conversation_toolbox')?>
            </div>           

        </div>
    </div>
</div>
<div class="row">
    <div id="main-header" class="col-md-8 col-xs-12 col-md-offset-2 well">
        <div class="col-md-4 col-xs-4" style="/*background-color: rgba(200, 219, 243, 0.6);*/ padding: 3px;"><h3>#<?php echo DriverTravel::getIdentifier($data); ?></h3>
            <?php echo TimeUtil::prettyDate($data['DriverTravel']['travel_date']) ?>
            <!--Control para el cambio de fecha-->
                    <?php if($userLoggedIn && ($userRole == 'admin' || $userRole == 'operator')):?>
                    <?php echo $this->element('form_travel_date_controls', array('travel'=>$data, 'keepOriginal'=>!$fechaCambiada, 'originalDate'=>strtotime($data['Travel']['date'])))?>
                    <?php endif; ?>
        </div>
        <?php if($hasProfile):?>
            <div class="col-md-4 col-xs-4 centeralign"><img class="pull-left" src="<?php echo $src?>" title="<?php echo $data['Driver']['DriverProfile']['driver_name']?>" style="max-height: 80px; max-width: 80px"/>
                <h4 style="padding-top: 15px; margin-left: 10px"><?php echo $this->html->link($data['Driver']['DriverProfile']['driver_name'],array('controller'=>'drivers', 'action'=>'profile/'.$data['Driver']['DriverProfile']['driver_nick']),array('target'=>'_blank')); ?></h4>
            </div>                    
        <?php endif;?>
    </div>
</div>


<!-- VIAJES Y CONTROLES -->
<div class="row" style="margin-top: 110px">    
        <div class="col-md-6 col-md-offset-3" >
        <?php        
            if($data['DriverTravel']['notification_type'] == DriverTravel::$NOTIFICATION_TYPE_DIRECT_MESSAGE)
                echo $this->element('direct_message', array('data'=>$data, 'show_header' => false, 'show_perfil' => false));
            else
                echo $this->element('travel', array('travel'=>$data, 'details'=>true, 'showConversations'=>false, 'actions'=>false, 'changeDate'=>true));
        ?>        
        </div>
        <div class="col-md-6 col-md-offset-3">
            <?php echo $this->element('conversation_controls', array('data'=>$data))?><!-- Acciones para esta conversación -->
        </div>
    

</div>



<div class="row">
    <div class="col-md-6 col-md-offset-3"><?php echo $this->element('addon_travel_arrangement');?></div>
    <div class="col-md-6 col-md-offset-3" id="travel_verification_div"><?php echo $this->element('addon_travel_verification');?></div>
    <div class="col-md-6 col-md-offset-3" id="testimonial_request_div"><?php echo $this->element('addon_testimonial_request');?></div>
    <div class="col-md-6 col-md-offset-3"><?php echo $this->element('addon_shared_ride_offer');?></div>
    <br/>
    <br/>

    <!-- MENSAJES -->
<?php if(empty ($conversations)):?><div class="col-md-6 col-md-offset-3">No hay conversaciones hasta el momento</div>
<?php else:?>
    <?php foreach ($conversations as $message):?>
    <div class="row container-fluid">
        <div class="col-md-9 col-md-offset-1">
            <?php echo $this->element('widget_conversation_message', array('message'=>$message['DriverTravelerConversation']))?>
        </div>
        <br/>
    </div>
    <?php endforeach;?>

<?php endif?>
</div>

<script type="text/javascript">
   /************** Logica para ocultar el panel superior****************/
       
    var prevscroll=window.pageYOffset;
        // on scroll, let the interval function know the user has scrolled
        $(window).scroll(function(event){
            var current = window.pageYOffset;
            
            if(prevscroll > current)
                document.getElementById("main-header").style.top="45px";
            else
                document.getElementById("main-header").style.top="-150px";
           
           prevscroll = current;
        });
        
        
        
    
    /************** FIN Logica para ocultar el panel superior****************/
    
    // Config box

    // SKIN Select
    $('.spin-icon').click(function () {
        $(".theme-config-box").toggleClass("show");
        if ($("#box-menu").hasClass('glyphicon glyphicon-chevron-left'))
            $("#box-menu").attr('class', 'glyphicon glyphicon-chevron-right');
        else
            $("#box-menu").attr('class', 'glyphicon glyphicon-chevron-left');
    });


</script>