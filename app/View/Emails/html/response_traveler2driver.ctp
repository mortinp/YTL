<?php App::uses('TimeUtil', 'Util')?>
<?php App::uses('DriverTravel', 'Model')?>

<?php echo Configure::read('email_message_separator')?>

<?php $travel_hint = ( $driver_travel['notification_type'] == DriverTravel::$NOTIFICATION_TYPE_DIRECT_MESSAGE ) ? __('para el').' '.TimeUtil::prettyDate($driver_travel['travel_date']) : $travel['origin'].' - '.$travel['destination']; ?>

<?php if(!isset ($driver_name)) $driver_name = 'chofer'?>
<div id="conversation-header">
    <div>Hola <?php echo $driver_name?>, tienes un nuevo mensaje de un viajero.</div> 
    <div>Para enviar tu respuesta, <b>responde este correo sin modificar el asunto</b>.</div>
</div>
<hr style="color:#efefef; background-color:#efefef; height:1px; max-height: 1px; border:none; margin-bottom: 10px;"/>

<p>Viaje <big><b>#<?php echo DriverTravel::getIdentifier($driver_travel); ?></b></big> <b><?php echo $travel_hint; ?></b>.</p> 
<p>
    <a href="<?php  echo $this->Html->url(array('controller'=>'drivers','action'=>'messages', $driver_travel['id'], 'base'=>false), true);
 ?>">Mira la conversación completa en nuestro sitio Web</a>
</p>
<p>A continuación puedes leer los <b>últimos <?php echo $messages_count?> mensajes</b> de la conversación:</p>


<?php
$email_text = '';
foreach($messages as $msg)
    $email_text .= trim ($this->element('pretty_message', array('message' => $msg['DriverTravelerConversation'], 'driver_name'=>'Tú', 'traveler_name'=>'Viajero'))).'<br/>';
?>

<div>
   <?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $email_text);?>
</div>

<hr style="color:#efefef; background-color:#efefef; height:1px; max-height: 1px; border:none; margin-top: 10px;margin-bottom: 10px;"/>
<div class="email-salute">
    <p><?php echo __d('conversation', 'Atentamente, el equipo de <em>YoTeLlevo</em>')?></p>
</div>