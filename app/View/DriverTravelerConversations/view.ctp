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
        <div style="float: left;padding-left: 20px;padding-top: 10px"><b><?php echo $this->Html->link('Viaje #'.$data['Travel']['id'].' »', array('controller'=>'travels', 'action'=>'admin', $data['Travel']['id']), array('title'=>'Administrar este viaje'));?></b></div>
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



<?php 
$hasMetadata = (isset ($data['TravelConversationMeta']) && $data['TravelConversationMeta'] != null && !empty ($data['TravelConversationMeta']) && strlen(implode($data['TravelConversationMeta'])) != 0);

$following = $hasMetadata? $data['TravelConversationMeta']['following']: false;
$asked_confirmation = $hasMetadata? $data['TravelConversationMeta']['asked_confirmation']: false;

$now = new DateTime(date('Y-m-d', time()));

$date_converted = strtotime($data['Travel']['date']);
$expired = CakeTime::isPast($date_converted) && !CakeTime::isToday($date_converted);
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


<?php if($expired && $following /*&& $daysExpired > 7*/):?>
<br/>
<br/>
<div class="col-md-6 col-md-offset-3" id="travel-verification">
    <span class="alert alert-warning" style="display: inline-block; width: 100%">
        <p>
            <b>Este viaje se está <span class="label label-info">Siguiendo</span> y está <span class="badge">expirado o realizándose hace <?php echo $daysExpired?> días</span></b>
        </p>
        <hr/>
        
        <?php if($asked_confirmation):?>
            <?php if($hasMetadata && $data['TravelConversationMeta']['received_confirmation_type'] != null):?> <!-- Confirmacion recibida -->
                <i class="glyphicon glyphicon-envelope"></i> Confirmación de viaje recibida:
                <br/>
                <br/>
                <div class="well"><?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", strip_tags($data['TravelConversationMeta']['received_confirmation_details']));?></div>
            <?php else:?>
                <i class="glyphicon glyphicon-share-alt"></i> Pedido de confirmación del viaje enviado al chofer. Esperando respuesta...
            <?php endif?>
            
        <?php else: ?>
            <p><b>No se ha enviado el pedido de confirmación del viaje al chofer</b></p>
            
            <p>Realiza las siguientes acciones para verificar que el viaje realmente pudo haberse realizado:</p>
            <ul>
                <li>Verifica que la fecha de expiración es correcta y que realmente expiró el viaje.</li>
                <li>Verifica que el chofer y el viajero se pusieron de acuerdo y hubo alguna forma de que se hayan encontrado.</li>
            </ul>
            <p>Si crees que debes verificar este viaje, da click en el siguiente botón.</p>
            <br/>

            <?php echo $this->Form->button('<i class="glyphicon glyphicon-share-alt"></i> Enviar correo de verificación al chofer', array('class'=>'btn-info btn-block', 'action'=>'ask_confirmation_to_driver/'.$data['DriverTravel']['id'], 'escape'=>false, 'confirm'=>'¿Está seguro que desea enviar un correo de verificación de este viaje al chofer?'), true);?>
        <?php endif; ?>
    </span>
</div>
<?php endif?>

