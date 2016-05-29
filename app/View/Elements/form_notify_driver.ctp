<?php 
if(!isset ($isArranged)) $isArranged = false;
if(!isset ($notificationType)) $notificationType = DriverTravel::$NOTIFICATION_TYPE_BY_ADMIN;
?>
<div>
    <?php echo $this->Form->create('Driver', array('url' => array('controller' => 'travels', 'action' =>'notify_driver_travel/'.$travel_id.'/'.$notificationType))); ?>
    <fieldset>
        <?php
        echo $this->Form->input('driver_id', array('type' => 'text', 'class'=>'driver-typeahead', 'label' => __('Chofer'), 'required'=>true, 'value'=>''));
        if($isArranged) echo $this->Form->input('TravelConversationMeta.arrangement', array('type' => 'textarea', 'label' => __('Detalles del acuerdo'), 'required'=>true, 'value'=>'', 'placeholder'=>'Ej. Viaje a Varadero por 60 CUC (descuento de 20 CUC)'));        
        echo $this->Form->submit('Notificar');
        ?>
    </fieldset>
    <?php echo $this->Form->end(); ?>
</div>