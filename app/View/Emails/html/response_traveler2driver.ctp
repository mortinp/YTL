<?php App::uses('TimeUtil', 'Util')?>
<?php App::uses('DriverTravel', 'Model')?>

<?php echo Configure::read('email_message_separator')?>

<?php $travel_hint = ( $driver_travel['notification_type'] == DriverTravel::$NOTIFICATION_TYPE_DIRECT_MESSAGE ) ? __('para el').' '.TimeUtil::prettyDate($driver_travel['travel_date']) : $travel['origin'].' - '.$travel['destination']; ?>

<?php if(!isset ($driver_name)) $driver_name = 'chofer'?>
<div id="conversation-header">
    <em>Hola <?php echo $driver_name?>. Este correo contiene la respuesta del viajero para el viaje <b>#<?php echo DriverTravel::getIdentifier($driver_travel); ?></b> <b><?php echo $travel_hint; ?></b>. Para enviar tu respuesta, <b>responde este correo sin modificar el asunto</b>.</em>
</div>
<hr style="color:#efefef; background-color:#efefef; height:1px; max-height: 1px; border:none; margin-bottom: 10px;"/>

<p><b>A continuación se listan los últimos mensajes:</b></p>

<div style="border-left: #efefef solid 2px;padding-left: 15px">
   <?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $response);?>
</div>

<hr style="color:#efefef; background-color:#efefef; height:1px; max-height: 1px; border:none; margin-top: 10px;margin-bottom: 10px;"/>
<div class="email-salute">
    <p><?php echo __d('conversation', 'Atentamente, el equipo de <em>YoTeLlevo</em>')?></p>
</div>