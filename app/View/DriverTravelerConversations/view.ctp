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
<?php $topPosition = 60?>
<div class="col-md-8 col-md-offset-2 well" id="fixed" style="position: fixed;top: <?php echo $topPosition?>px;z-index: 100;background-color: white;padding:10px">
    <div style="width: 100%">
        <?php if($hasProfile):?><div style="float: left"><img src="<?php echo $src?>" title="<?php echo $data['Driver']['DriverProfile']['driver_name'].' - '.$data['Driver']['username']?>" style="max-height: 30px; max-width: 30px"/></div><?php endif;?>
        <div style="float: left;padding-left: 10px"><h4>Conversación con <?php echo $driverName?></h4></div>
        <div style="float: left;padding-left: 20px;padding-top: 10px"><b>Viaje #<?php echo $data['Travel']['id']?></b></div>
    </div>
</div>
<div style="height: 85px;"></div> <!-- Separator -->
    

<!-- VIAJES Y CONTROLES -->
<div class="row" style="top: 200px">
    <div class="col-md-6 col-md-offset-3">
        <?php echo $this->element('travel', array('travel'=>$data, 'details'=>true, 'showConversations'=>false, 'actions'=>false, 'changeDate'=>true))?>
        <div>
            <?php echo $this->element('conversation_controls', array('data'=>$data))?><!-- Acciones para esta conversación -->
        </div>
    </div>
</div>

<div class="col-md-6 col-md-offset-3"><?php echo $this->element('addon_travel_arrangement');?></div>
<div class="col-md-6 col-md-offset-3"><?php echo $this->element('addon_travel_verification');?></div>
<div class="col-md-6 col-md-offset-3"><?php echo $this->element('addon_testimonial_request');?></div>

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
    $(window).scroll(function(){
        $("#fixed").css("top", Math.max(0, <?php echo $topPosition?> - $(this).scrollTop()));
    });
</script>