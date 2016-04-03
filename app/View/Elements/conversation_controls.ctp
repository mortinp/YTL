<?php $following = false;?>
<?php if(isset ($data['TravelConversationMeta']) && $data['TravelConversationMeta'] != null && !empty ($data['TravelConversationMeta'])):?>
    <?php $following = $data['TravelConversationMeta']['following']; ?>

    <b>Estado:</b>
    <ol class="breadcrumb">
        <li><a class="<?php if($data['TravelConversationMeta']['state'] != DriverTravelerConversation::$STATE_NONE) echo 'btn btn-default'; else echo 'badge'?>" href="<?php echo $this->Html->url(array('action'=>'set_state/'.$data['DriverTravel']['id'].'/'.DriverTravelerConversation::$STATE_NONE))?>">Ninguno</a></li>
        <li><a class="<?php if($data['TravelConversationMeta']['state'] != DriverTravelerConversation::$STATE_TRAVEL_DONE) echo 'btn btn-warning'; else echo 'badge'?>" href="<?php echo $this->Html->url(array('action'=>'set_state/'.$data['DriverTravel']['id'].'/'.DriverTravelerConversation::$STATE_TRAVEL_DONE))?>" title="Marcar si se comprobó que el viaje se realizó"><i class="glyphicon glyphicon-thumbs-up"></i> Realizado</a></li>
        <li><a class="<?php if($data['TravelConversationMeta']['state'] != DriverTravelerConversation::$STATE_TRAVEL_PAID) echo 'btn btn-success'; else echo 'badge'?>" href="<?php echo $this->Html->url(array('action'=>'set_state/'.$data['DriverTravel']['id'].'/'.DriverTravelerConversation::$STATE_TRAVEL_PAID))?>" title="Marcar si el viaje ya fue pagado por el chofer"><i class="glyphicon glyphicon-usd"></i> Pagado</a></li>
    </ol>
    <?php
    if($data['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_PAID) {
        echo $this->element('travel_income_controls', array('thread'=>$data['DriverTravel'], 'conversation'=>$data));
    }
    ?>
<?php endif?>

<hr/>

<?php $hasMetadata = (isset ($data['TravelConversationMeta']) && $data['TravelConversationMeta'] != null && !empty ($data['TravelConversationMeta']) && strlen(implode($data['TravelConversationMeta'])) != 0);?>

    
<b>Mensajes:</b>
<?php
// Cantidad total de mensajes
if($data['DriverTravel']['driver_traveler_conversation_count'] > 0):?>
    <span class="label label-primary"><?php echo $data['DriverTravel']['driver_traveler_conversation_count']?> mensajes en total</span>
<?php endif?>

<!-- +1 -->
<?php
$unreadMessages = 0;
if($hasMetadata) {
    if($data['TravelConversationMeta']['read_entry_count'] < $data['DriverTravel']['driver_traveler_conversation_count']) {
        $unreadMessages = $data['DriverTravel']['driver_traveler_conversation_count'] - $data['TravelConversationMeta']['read_entry_count'];
    }
} else if($data['DriverTravel']['driver_traveler_conversation_count'] > 0) {
    $unreadMessages = $data['DriverTravel']['driver_traveler_conversation_count'];
}
?>
<?php if($unreadMessages != 0):?>
    <span class="label label-success" style="margin-left:5px" title="<?php echo $unreadMessages?> nuevos mensajes">+<?php echo $unreadMessages?></span>
    
    <?php $firstUnreadMessage = $conversations[count($conversations) - $unreadMessages]['DriverTravelerConversation'];?>
    <span><a href="#message-<?php echo $firstUnreadMessage['id']?>">&ndash; ir al primer mensaje nuevo</a></span>
    
    <?php echo $this->Form->button('Marcar todos como leídos', array('class'=>'btn-primary', 'action'=>'update_read_entries/'.$data['DriverTravel']['id'].'/'.count($conversations)), true);?>
<?php else:?> No hay mensajes nuevos <?php endif?>

<hr/>
<span>
    <?php
    if($following) echo $this->Form->button('Quitar seguimiento', array('class'=>'btn-danger', 'action'=>'unfollow/'.$data['DriverTravel']['id']), true); 
    else echo $this->Form->button('Seguir esta conversación', array('class'=>'btn-info', 'action'=>'follow/'.$data['DriverTravel']['id']), true);
    ?>
</span>