<?php $driverName = 'el chofer'.' <small class="text-muted">('.$data['Driver']['username'].')</small>'?>
<?php $hasProfile = isset ($data['Driver']['DriverProfile']) && $data['Driver']['DriverProfile'] != null && !empty ($data['Driver']['DriverProfile'])?>
<?php if($hasProfile) :?>
    <?php
        $src = '';
        if(Configure::read('debug') > 0) $src .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien
        $src .= '/'.str_replace('\\', '/', $data['Driver']['DriverProfile']['avatar_filepath']);
        
        $driverName = $data['Driver']['DriverProfile']['driver_name'].' <small class="text-muted">('.$data['Driver']['username'].')</small>';
    ?>
<?php endif;?>
<?php
//New for correct working on travel date change
$travelDate = DriverTravel::extractDate($data);
?>
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
        padding-bottom: 80px;
    }
    .theme-config-box {
        margin-right: -220px;
        position: relative;        
        transition-duration: 0.4s;

    }
    .theme-config-box.show {
        margin-right: 0;
    }
    .spin-icon {
        /*background:#06f;*/
        position: absolute;
        padding: 3px;
        padding-right: 20px;
        /*border-radius: 20px 0 0 20px;*/
        font-size: 20px;
        top: 150px;
        left: 0;	
        /*color: #fff;*/
        cursor: pointer;
        /*opacity: .8;*/
        height: 35px;
    }
    .skin-settings {
        width: 220px;
        margin-left: 43px;
        background-color: rgba(200, 219, 243, 0.6);
        /*box-shadow:  5px 1px 1px 2px rgba(0, 0, 0, 0.4);*/
        border-radius: 0 0 0 10px;
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
<?php $topPosition = 60?>
<?php $fechaCambiada = isset ($data['DriverTravel']['original_date']) && $data['DriverTravel']['original_date'] != null;?>
        
<div class="row">
<!--Nueva posicion para el render del flash-->
<div class="col-md-9 col-md-offset-2">
<!--Iria aqui dentro para vista de admin-->
</div>
<!--Header animado que entra y sale-->
    <div id="main-header" class="col-md-8 col-md-offset-2 col-xs-12 well">
        <div class="row" style="/*background-color: rgba(200, 219, 243, 0.6);*/ padding: 3px;">
            
            <div class="col-md-6 col-xs-12">
                <?php if($hasProfile):?><div style="float: left"><img src="<?php echo $src?>" title="<?php echo $data['Driver']['DriverProfile']['driver_name']?>" style="max-height: 30px; max-width: 30px"/></div> <?php endif;?>
                <div style="float: left;padding-left: 10px"><h4><?php echo $this->html->link($data['Driver']['DriverProfile']['driver_name'],array('controller'=>'drivers', 'action'=>'profile/'.$data['Driver']['DriverProfile']['driver_nick']),array('target'=>'_blank', 'style'=>'color:inherit')); ?></h4></div>
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="row">
                    <div class="col-md-2">
                        <span><span class="text-muted">#</span><big><big><?php echo DriverTravel::getIdentifier($data)?></big></big></span>
                    </div>
                    <div class="col-md-8">
                        <!-- SIGUIENDO -->
                        <?php if($data['TravelConversationMeta']['following']):?> 
                             <small><span class="label label-info" style="margin-left:5px">Siguiendo</span></small>
                        <?php endif?> 
                        <!-- ESTADOS -->
                        <?php if($data['TravelConversationMeta']['state'] != DriverTravelerConversation::$STATE_NONE):?>
                        
                            <?php if($data['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_DONE):?>
                                <small><span class="label label-warning" style="margin-left:5px"><i class="glyphicon glyphicon-thumbs-up"></i> Realizado</span></small>
                            <?php elseif($data['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_PAID):?>
                                <small><span class="label label-success" style="margin-left:5px"><i class="glyphicon glyphicon-usd"></i> Pagado</span></small>
                            <?php endif?>                        
                         
                        <?php endif?>
                    </div>
                </div>
                
                <br/>
                <?php echo TimeUtil::prettyDate($data['DriverTravel']['travel_date']) ?>
                
                <!--Control para el cambio de fecha-->
                <?php if($userLoggedIn && ($userRole == 'admin' || $userRole == 'operator')):?>
                <?php echo $this->element('form_travel_date_controls', array('travel'=>$data, 'keepOriginal'=>!$fechaCambiada, 'originalDate'=>strtotime($travelDate)))?>
                <?php endif; ?>
            </div>
            
        </div>
        
    </div>
</div>
<div class="theme-config">
    <div class="theme-config-box">
        <div class="spin-icon alert alert-info">
            <i id="box-menu" class="glyphicon glyphicon-chevron-left pull-left"></i>
        </div>
        <div class="skin-settings">            
            <div class="well">
                   <?php echo $this->element('conversation_toolbox')?>
            </div>
        </div>
    </div>
</div>  

<!-- VIAJES Y CONTROLES -->
<div class="row" style="margin-top: 110px">
    <div class="col-md-6 col-md-offset-3">
        <?php
            if($data['DriverTravel']['notification_type'] == DriverTravel::$NOTIFICATION_TYPE_DIRECT_MESSAGE)
                echo $this->element('direct_message', array('data'=>$data, 'show_header' => false, 'show_perfil' => false));
            else
                echo $this->element('travel', array('travel'=>$data, 'details'=>true, 'showConversations'=>false, 'actions'=>false, 'changeDate'=>true));
        ?>
        <div>
            <?php echo $this->element('conversation_controls', array('data'=>$data))?><!-- Acciones para esta conversación -->
        </div>
    </div>
</div>

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
	
	// SKIN Select
    $('.spin-icon').click(function () {		
        $(".theme-config-box").toggleClass("show");
        if ($("#box-menu").hasClass('glyphicon glyphicon-chevron-left'))
            $("#box-menu").attr('class', 'glyphicon glyphicon-chevron-right');
        else
            $("#box-menu").attr('class', 'glyphicon glyphicon-chevron-left');
    });

    
</script>


<script type="text/javascript">
    $(window).scroll(function(){
        $("#fixed").css("top", Math.max(50, <?php echo $topPosition?> - $(this).scrollTop()));
    });
</script>