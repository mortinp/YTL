<?php App::uses('TimeUtil', 'Util')?>

<?php 
if(!isset($showComments)) $showComments = true;

if(isset ($conversation['DriverTravel'])) 
    $thread = $conversation['DriverTravel'];
else $thread = $conversation;

$hasMetadata = (isset ($conversation['TravelConversationMeta']) && $conversation['TravelConversationMeta'] != null && !empty ($conversation['TravelConversationMeta']) && strlen(implode($conversation['TravelConversationMeta'])) != 0);
?>


<?php
// Cantidad total de mensajes
if($thread['message_count'] > 0): // Respondido ?> 
     <small><span class="label label-primary"><?php echo $thread['message_count'];?> mensajes en total</span></small>
<?php endif?>
     
<!-- MENSAJES SIN LEER --> 
<?php 
$unread = 0;
if($hasMetadata) {
     if($conversation['TravelConversationMeta']['read_entry_count'] < $thread['message_count']) {
         $unread = $thread['message_count'] - $conversation['TravelConversationMeta']['read_entry_count'];
     }
} else if($thread['message_count'] > 0) {
    $unread = $thread['message_count'];
}
?>
<?php if($unread > 0):?>
    <small><span class="label label-success"><?php echo $unread?> nuevos mensajes</span></small>
<?php endif?>

<div>
    <?php echo $this->Html->link('Mira los mensajes de esta conversación', array('controller'=>'driver_traveler_conversations', 'action'=>'view/'.$thread['id']));?>
</div>
