<?php 
if(!isset($showComments)) $showComments = true;

if(isset ($conversation['DriverTravel'])) 
    $thread = $conversation['DriverTravel'];
else $thread = $conversation;

$hasMetadata = (isset ($conversation['TravelConversationMeta']) && $conversation['TravelConversationMeta'] != null && !empty ($conversation['TravelConversationMeta']) && strlen(implode($conversation['TravelConversationMeta'])) != 0);
?>

<?php
$info = array();
if(isset ($conversation['Driver'])) $info['title'] = $conversation['Driver']['username'];
if($thread['notification_type'] == DriverTravel::$NOTIFICATION_TYPE_BY_ADMIN) $info['class'] = 'text-muted';
if($thread['notification_type'] == DriverTravel::$NOTIFICATION_TYPE_PREARRANGED) $info['class'] = 'text-success';
        
echo $this->Html->link($thread['id'], array('controller'=>'driver_traveler_conversations', 'action'=>'view/'.$thread['id']), $info);

// Cantidad total de mensajes
if($thread['driver_traveler_conversation_count'] > 0) { // Respondido
    echo '<div style="float:left" title="'.$thread['driver_traveler_conversation_count'].' mensajes en total"><div class="label label-primary" style="margin-left: -30px;">'.$thread['driver_traveler_conversation_count'].'</div></div>';
}
?>

<!-- COMMENTS -->
<?php if($showComments):?>
<div style="float:right;margin-right: 30px;">
    <?php echo $this->element('travel_comments_controls', array('thread' => $thread, 'conversation'=>$conversation)); ?>
    &nbsp;
</div>
<?php endif?>

<!-- ARRANGEMENTS -->
<?php if(isset ($conversation['TravelConversationMeta']['arrangement']) && !empty($conversation['TravelConversationMeta']['arrangement'])):?>
<div style="float:right;margin-right: 10px">
    <span class="info" title="<?php echo $conversation['TravelConversationMeta']['arrangement']?>"><i class="glyphicon glyphicon-thumbs-up"></i></span>
</div>
<?php endif?>



<?php if($hasMetadata):?>

    <!-- SIGUIENDO -->
    <?php if($conversation['TravelConversationMeta']['following']):?> 
        <span class="label label-info" style="margin-left:5px">Siguiendo</span>
    <?php endif?>

    <!-- +1 -->
    <?php if($conversation['TravelConversationMeta']['read_entry_count'] < $thread['driver_traveler_conversation_count']):?>
    <span class="label label-success" style="margin-left:5px" title="<?php echo ($thread['driver_traveler_conversation_count'] - $conversation['TravelConversationMeta']['read_entry_count'])?> nuevos mensajes">+<?php echo ($thread['driver_traveler_conversation_count'] - $conversation['TravelConversationMeta']['read_entry_count'])?></span>
    <?php endif?>

    <!-- ESTADOS -->
    <?php if($conversation['TravelConversationMeta']['state'] != DriverTravelerConversation::$STATE_NONE):?>
        <?php if($conversation['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_DONE):?>
            <span class="label label-warning" style="margin-left:5px" title="Viaje realizado"><i class="glyphicon glyphicon-thumbs-up"></i> Realizado</span>
        <?php elseif($conversation['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_PAID):?>
            <span class="label label-success" style="margin-left:5px" title="Viaje pagado"><i class="glyphicon glyphicon-usd"></i> Pagado</span>
        <?php endif?>
    <?php endif?>

<?php elseif($thread['driver_traveler_conversation_count'] > 0):?>
    <!-- +1 -->
    <span class="label label-success" style="margin-left:5px" title="<?php echo ($thread['driver_traveler_conversation_count'])?> nuevos mensajes">+<?php echo ($thread['driver_traveler_conversation_count'])?></span>
<?php endif?>


    
<!-- GANANCIAS -->
<?php 
if($hasMetadata && $conversation['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_PAID) 
    echo $this->element('travel_income_controls', array('thread' => $thread, 'conversation'=>$conversation));
    echo '&nbsp;' ;
?>