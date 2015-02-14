<?php
$driver_intro = __d('conversation', 'El chofer');
$driver_desc = '#'.$driver['id'];
$driver_avatar = null;

if(isset ($driver['DriverProfile']) && !empty($driver['DriverProfile'])) {
    $driver_intro = $driver['DriverProfile']['driver_name'];
    $driver_desc = $driver['DriverProfile']['driver_name'];
    
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
    <?php if($driver_avatar != null):?>
    <p><img class="driver-avatar" src="<?php echo $driver_avatar?>" alt="<?php echo $driver['DriverProfile']['driver_name']?>"/></p>
    <?php endif;?>
    <p><b><?php echo __d('conversation', '%s dice', $driver_intro)?>:</b></p>
</div>


<div>
   <?php 
   //1
   echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $response);
   
   //2
   //echo nl2br($response);
   
   /*//3
   $lines = preg_split("/(\r\n|\n|\r)/", $response);
   foreach ($lines as $l) {
       echo $l."\n";
   }*/
   
   //4
   //echo $response 
   ?>
</div>

<hr style="color:#efefef; background-color:#efefef; height:1px; max-height: 1px; border:none; margin-top: 10px;margin-bottom: 10px;"/>
<div class="email-salute">
    <p><?php echo __d('conversation', 'Atentamente, el equipo de <em>YoTeLlevo</em>')?></p>
</div>
