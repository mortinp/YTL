<?php
$following = false;
if(isset ($data['TravelConversationMeta']) && $data['TravelConversationMeta'] != null && !empty ($data['TravelConversationMeta'])) {
    $following = $data['TravelConversationMeta']['following'];

    // Controles de estado del viaje
    echo '<b>Estado:</b> ';
    if($data['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_NONE) $none = '<span class="badge">NINGUNO</span> ';
    else $none = $this->Form->button('Ninguno', array('class'=>'btn-default', 'action'=>'set_state/'.$data['DriverTravel']['id'].'/'.DriverTravelerConversation::$STATE_NONE, 'escape'=>false, 'title'=>'Marcar si el viaje no tiene ningún estado'), true).' '; 
    //if($data['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_NOT_DONE) $notdone = '<span class="badge">NO REALIZADO</span> ';
    //else $notdone = $this->Form->button('<i class="glyphicon glyphicon-thumbs-down"></i> No realizado', array('class'=>'btn-danger', 'action'=>'set_state/'.$data['DriverTravel']['id'].'/'.DriverTravelerConversation::$STATE_TRAVEL_NOT_DONE, 'escape'=>false, 'title'=>'Marcar si se comprobó que el viaje no se realizó'), true).' ';
    if($data['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_DONE) $done = '<span class="badge">REALIZADO</span> ';
    else $done = $this->Form->button('<i class="glyphicon glyphicon-thumbs-up"></i> Realizado', array('class'=>'btn-warning', 'action'=>'set_state/'.$data['DriverTravel']['id'].'/'.DriverTravelerConversation::$STATE_TRAVEL_DONE.'/'.$data['Travel']['User']['id'], 'escape'=>false, 'title'=>'Marcar si se comprobó que el viaje se realizó'), true).' '; 
    if($data['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_PAID) $paid = '<span class="badge">PAGADO</span> ';
    else $paid = $this->Form->button('<i class="glyphicon glyphicon-usd"></i> Pagado', array('class'=>'btn-warning', 'action'=>'set_state/'.$data['DriverTravel']['id'].'/'.DriverTravelerConversation::$STATE_TRAVEL_PAID, 'escape'=>false, 'title'=>'Marcar si el viaje ya fue pagado por el chofer'), true).' ';

    echo $none; /*echo $notdone;*/ echo $done; echo $paid;
    echo '<br/><br/>';
}

if($following) echo $this->Form->button('Quitar seguimiento', array('class'=>'btn-danger', 'action'=>'unfollow/'.$data['DriverTravel']['id']), true); 
else echo $this->Form->button('Seguir esta conversación', array('class'=>'btn-info', 'action'=>'follow/'.$data['DriverTravel']['id']), true);

echo ' ';
echo $this->Form->button('Marcar todos como leídos', array('class'=>'btn-primary', 'action'=>'update_read_entries/'.$data['DriverTravel']['id'].'/'.count($conversations)), true);
?>