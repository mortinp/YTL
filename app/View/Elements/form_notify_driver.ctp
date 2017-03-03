<?php 
if(!isset ($isArranged)) $isArranged = false;
if(!isset ($notificationType)) $notificationType = DriverTravel::$NOTIFICATION_TYPE_BY_ADMIN;
?>
<div>
    <?php echo $this->Form->create('Driver', array('url' => array('controller' => 'travels', 'action' =>'notify_driver_travel/'.$travel_id.'/'.$notificationType))); ?>
    <fieldset>
        <?php
        echo $this->Form->input('driver_id', array('type' => 'text', 'class'=>'driver-typeahead', 'label' => __('Chofer'), 'required'=>true, 'value'=>''));
        if($isArranged) echo $this->Form->input('TravelConversationMeta.arrangement', array('type' => 'textarea', 'label' => __('Envía una nota al chofer con los detalles del acuerdo (recorridos, precios, etc.) y todos los detalles que se tengan del viaje (nombres de los clientes, datos del vuelo, nacionalidad o idioma, lugar de recogida inicial, etc.). <big>Esta nota la recibe el chofer junto con la notificación</big>.'), 'required'=>true, 'value'=>''));        
        echo $this->Form->submit('Notificar');
        ?>
    </fieldset>
    <?php echo $this->Form->end(); ?>
</div>