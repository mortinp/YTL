<?php $following = false;?>
<?php if(isset ($data['TravelConversationMeta']) && $data['TravelConversationMeta'] != null && !empty ($data['TravelConversationMeta'])):?>
    <?php $following = $data['TravelConversationMeta']['following']; ?>

    <b>Estado:</b>
    <div>
        <ol class="breadcrumb">
            <li><a class="btn btn-default <?php if($data['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_NONE) echo 'disabled btn-lg'?>" href="<?php echo $this->Html->url(array('action'=>'set_state/'.$data['DriverTravel']['id'].'/'.DriverTravelerConversation::$STATE_NONE))?>">Ninguno</a></li>
            <li><a class="btn btn-warning <?php if($data['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_DONE) echo 'disabled btn-lg'?>" href="<?php echo $this->Html->url(array('action'=>'set_state/'.$data['DriverTravel']['id'].'/'.DriverTravelerConversation::$STATE_TRAVEL_DONE.'/'.$data['Travel']['User']['id']))?>" title="Marcar si se comprobó que el viaje se realizó"><i class="glyphicon glyphicon-thumbs-up"></i> Realizado</a></li>
            <li><a class="btn btn-success <?php if($data['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_PAID) echo 'disabled btn-lg'?>" href="<?php echo $this->Html->url(array('action'=>'set_state/'.$data['DriverTravel']['id'].'/'.DriverTravelerConversation::$STATE_TRAVEL_PAID))?>" title="Marcar si el viaje ya fue pagado por el chofer"><i class="glyphicon glyphicon-usd"></i> Pagado</a></li>
        </ol>
    </div>    
    <br/>
<?php endif?>
    
<?php
if($following) echo $this->Form->button('Quitar seguimiento', array('class'=>'btn-danger', 'action'=>'unfollow/'.$data['DriverTravel']['id']), true); 
else echo $this->Form->button('Seguir esta conversación', array('class'=>'btn-info', 'action'=>'follow/'.$data['DriverTravel']['id']), true);

echo ' ';
echo $this->Form->button('Marcar todos como leídos', array('class'=>'btn-primary', 'action'=>'update_read_entries/'.$data['DriverTravel']['id'].'/'.count($conversations)), true);
?>