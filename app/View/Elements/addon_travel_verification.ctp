<?php 
$hasMetadata = (isset ($data['TravelConversationMeta']) && $data['TravelConversationMeta'] != null && !empty ($data['TravelConversationMeta']) && strlen(implode($data['TravelConversationMeta'])) != 0);

$is_done = !$hasMetadata || $data['TravelConversationMeta']['state'] != DriverTravelerConversation::$STATE_NONE;

$following = $hasMetadata && $data['TravelConversationMeta']['following'];
$asked_confirmation = $hasMetadata && $data['TravelConversationMeta']['asked_confirmation'];

$now = new DateTime(date('Y-m-d', time()));

//$date_converted = strtotime($data['Travel']['date']);
$expired = $data['Travel']['is_expired'];//CakeTime::isPast($date_converted) && !CakeTime::isToday($date_converted);
if($expired) {
    $daysExpired = $now->diff(new DateTime($data['Travel']['date']), true)->format('%a');
}

$hasMessages = count($conversations) > 0;
if($hasMessages) {
    $lastMessage = $conversations[count($conversations) - 1]['DriverTravelerConversation'];
    $daysLastMessage = $now->diff(new DateTime($lastMessage['created']), true)->format('%a');
}

$daysToGo = $now->diff(new DateTime($data['Travel']['date']), true)->format('%a');
?>

<div id='conversation-alerts'>
    <?php if(!$expired && $following && CakeTime::isWithinNext('2 weeks',  strtotime($data['Travel']['date']))):?>
        <?php if($hasMessages && $daysLastMessage > 15):?>
            <span class="alert alert-warning" style="display: inline-block; width: 100%"><i class="glyphicon glyphicon-warning-sign"></i> No hay mensajes nuevos <span class="badge">hace <?php echo $daysLastMessage?> días</span> y el viaje es <span class="label label-success">dentro de <?php echo $daysToGo?> días</span>. <b>Toma las precauciones necesarias!</b></span>
        <?php else: ?>
            <span class="alert alert-info" style="display: inline-block; width: 100%"><i class="glyphicon glyphicon-exclamation-sign"></i> Este viaje debe comenzar <span class="label label-success">dentro de <?php echo $daysToGo?> días</span>. <b>Verifica que todo esté listo!</b></span>
        <?php endif?>
    <?php endif?>
</div>

<?php if(($expired && $following) || $asked_confirmation):?>
<div id="travel-verification">
    
        
    <?php if($expired && $following && !$asked_confirmation):?>
        <span class="alert alert-warning" style="display: inline-block; width: 100%">
            <p>
                <b>Este viaje se está <span class="label label-info">Siguiendo</span> y está <span class="badge">expirado o realizándose hace <?php echo $daysExpired?> días</span></b>
            </p>
            <hr/>
            <p><b>No se ha enviado el pedido de confirmación del viaje al chofer</b></p>

            <p>Realiza las siguientes acciones para verificar que el viaje realmente pudo haberse realizado:</p>
            <ul>
                <li>Verifica que la fecha de expiración es correcta y que realmente expiró el viaje.</li>
                <li>Verifica que el chofer y el viajero se pusieron de acuerdo y hubo alguna forma de que se hayan encontrado.</li>
            </ul>
            <p>Si crees que debes verificar este viaje, da click en el siguiente botón.</p>
            <br/>

            <?php echo $this->Form->button('<i class="glyphicon glyphicon-share-alt"></i> Enviar correo de verificación al chofer', array('class'=>'btn-info btn-block', 'action'=>'ask_confirmation_to_driver/'.$data['DriverTravel']['id'], 'escape'=>false, 'confirm'=>'¿Está seguro que desea enviar un correo de verificación de este viaje al chofer?'), true);?>
        </span>
    <?php endif;?>
        
    <?php if($asked_confirmation):?>
        
        <?php if($hasMetadata && $data['TravelConversationMeta']['received_confirmation_type'] != null):?> <!-- Confirmacion recibida -->
            <span class="alert alert-warning" style="display: inline-block; width: 100%">
                <i class="glyphicon glyphicon-envelope"></i> Confirmación de viaje recibida:
                <br/>
                <br/>
                <div class="well"><?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", strip_tags($data['TravelConversationMeta']['received_confirmation_details']));?></div>
            </span>
        <?php else:?>
            <?php if(!$is_done):?>
                <span class="alert alert-warning" style="display: inline-block; width: 100%">
                <i class="glyphicon glyphicon-share-alt"></i> Pedido de confirmación del viaje enviado al chofer. Esperando respuesta...<?php endif; ?>
            </span>
        <?php endif?>
        
    <?php endif; ?>
                
    
</div>
<?php endif?>