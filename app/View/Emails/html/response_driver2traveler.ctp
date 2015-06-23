<?php
$driver_intro = __d('conversation', 'El chofer');
$driver_desc = '#'.$driver['id'];
$driver_avatar = null;
$show_profile = false;

if(isset ($driver['DriverProfile']) && !empty($driver['DriverProfile'])) {
    $driver_intro = $driver['DriverProfile']['driver_name'];
    $driver_desc = $driver['DriverProfile']['driver_name'];
    if(isset ($driver['DriverProfile']['show_profile']) && $driver['DriverProfile']['show_profile'])
        $show_profile = true;
    
    $fullBaseUrl = Configure::read('App.fullBaseUrl');
    if(Configure::read('debug') > 0) $fullBaseUrl .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien
    
    $driver_avatar = $fullBaseUrl.'/'.str_replace('\\', '/', $driver['DriverProfile']['avatar_filepath']);
}
?>

<div id="conversation-header">
    <p>
        <em><?php echo __d('conversation', 'Hola viajero. Este correo contiene la respuesta del chofer <b>%s</b> de YoTeLlevo, notificado con los datos de tu viaje <b>%s</b>. Para enviar tu respuesta, <b>responde este correo sin modificar el asunto</b>.', $driver_desc, $travel['origin'].' - '.$travel['destination'])?></em>   
    </p>
</div>
<hr style="color:#efefef; background-color:#efefef; height:1px; max-height: 1px; border:none; margin-bottom: 10px;"/>

<div>
    <?php if($show_profile):?>    
        <p>
            <?php
            $profile_path = $fullBaseUrl.'/driver_traveler_conversations/show_profile/'.$conversation_id;
            //echo $this->Html->link(__d('conversation', 'Vea fotos de %s y su auto', $driver_intro), array('controller'=>'driver_traveler_conversations', 'action'=>'show_profile/'.$conversation_id)) 
            ?>
            <a href="<?php echo $profile_path?>"><?php echo __d('conversation', 'Vea fotos de %s y su auto', $driver_intro)?></a>
        </p>
    <?php endif;?>
        
    <?php if($driver_avatar != null):?>
    <p><img class="driver-avatar" src="<?php echo $driver_avatar?>" alt="<?php echo $driver['DriverProfile']['driver_name']?>"/></p>
    <?php endif;?>
    
    <p><b><?php echo __d('conversation', '%s dice', $driver_intro)?>:</b></p>
</div>


<div style="border-left: #efefef solid 2px;padding-left: 15px">
   <?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $response);?>
</div>

<hr style="color:#efefef; background-color:#efefef; height:1px; max-height: 1px; border:none; margin-top: 10px;margin-bottom: 10px;"/>
<div class="email-salute">
    <p><?php echo __d('conversation', 'Atentamente, el equipo de <em>YoTeLlevo</em>')?></p>
    <p><a href="http://yotellevocuba.com">yotellevocuba.com</a> | <a href="https://www.facebook.com/yotellevoTaxiCuba">Facebook</a></p>
</div>