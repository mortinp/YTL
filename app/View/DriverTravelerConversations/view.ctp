<?php

$driverName = 'el chofer'.' <small class="text-muted">('.$data['Driver']['username'].')</small>'?>
<?php $hasProfile = isset ($data['Driver']['DriverProfile']) && $data['Driver']['DriverProfile'] != null && !empty ($data['Driver']['DriverProfile'])?>
<?php if($hasProfile) :?>
    <?php
        $src = '';
        if(Configure::read('debug') > 0) $src .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien
        $src .= '/'.str_replace('\\', '/', $data['Driver']['DriverProfile']['avatar_filepath']);
        
        $driverName = $data['Driver']['DriverProfile']['driver_name'].'</small>';
    ?>
<?php endif;?>
<?php $topPosition = 60?>

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
        position: absolute;
        top: 100px;
        right: 0; 
        overflow: hidden;
    }
    .theme-config-box {
        margin-right: -220px;
        position: relative;
        z-index: 2000;
        transition-duration: 1.5s;

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
        background-color: rgba(200, 219, 243, 1);
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



</style>

<div class="theme-config">
    <div class="theme-config-box">
        <div class="spin-icon">
            <i id="box-menu" class="glyphicon glyphicon-chevron-left pull-left"></i><i class="glyphicon glyphicon-list pull-right"></i>
        </div>
        <div class="skin-settings">
            <div class="col-md-12" style="padding-top: 5px; margin-bottom: 3px"><span class="btn-primary col-md-12 text-center" style="margin: 0px"><b>Operaciones</b></span></div>
            <div class="setings-item">
                   <?php echo $this->element('conversation_toolbox')?>
            </div>           

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-9 col-md-offset-2 well" style="background-color: white">
        <?php if($hasProfile):?><div class="col-md-3"><img src="<?php echo $src?>" title="<?php echo $data['Driver']['DriverProfile']['driver_name']?>" style="max-height: 30px; max-width: 30px"/></div><?php endif;?>
        <div class="col-md-9" style="padding-left: 10px"><h4>Chofer <?php echo $driverName?></h4></div>

    </div>
</div>


<!-- VIAJES Y CONTROLES -->
<div class="row">    
        <div class="col-md-6 col-md-offset-3">
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
<?php if(empty ($conversations)):?><div class="row"><div class="col-md-6 col-md-offset-3">No hay conversaciones hasta el momento</div></div>
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