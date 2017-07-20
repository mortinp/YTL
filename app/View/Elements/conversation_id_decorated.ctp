<?php App::uses('TimeUtil', 'Util')?>

<?php 
if(!isset($showComments)) $showComments = true;

if(isset ($conversation['DriverTravel'])) 
    $thread = $conversation['DriverTravel'];
else $thread = $conversation;

$hasMetadata = (isset ($conversation['TravelConversationMeta']) && $conversation['TravelConversationMeta'] != null && !empty ($conversation['TravelConversationMeta']) && strlen(implode($conversation['TravelConversationMeta'])) != 0);
?>

<?php
$info = array('class'=>'info');
if(isset ($conversation['Driver'])) $info['title'] = $conversation['Driver']['username'];
if($thread['notification_type'] == DriverTravel::$NOTIFICATION_TYPE_BY_ADMIN) $info['class'] .= ' text-muted';
if($thread['notification_type'] == DriverTravel::$NOTIFICATION_TYPE_PREARRANGED) $info['class'] .= ' text-success';
        
echo $this->Html->link($thread['id'], array('controller'=>'driver_traveler_conversations', 'action'=>'view/'.$thread['id']), $info);
?>

<?php $badgesMargin = -30; $badgesSpacing = 25;?>
<?php if($hasMetadata):?>

    
    <!-- VERIFICACION DE VIAJE -->
    <?php if($conversation['TravelConversationMeta']['received_confirmation_type'] != null):?>
        <!-- Verificacion recibida --> 
        <small>
            <span title='<b>Confirmación de Viaje:</b><br/><?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", strip_tags($conversation['TravelConversationMeta']['received_confirmation_details']));?>' class="label label-info info" data-trigger="click" style="float:left;margin-left: <?php echo $badgesMargin; $badgesMargin-=$badgesSpacing?>px;">
                <a href="#!">
                    <i class="glyphicon glyphicon-envelope"></i>
                </a>
            </span>
        </small>
    <?php elseif($hasMetadata && $conversation['TravelConversationMeta']['asked_confirmation']):?>
        <!-- Pedido de confirmacion enviado al chofer -->    
        <small>
            <span class="label label-default info" style="float:left;margin-left: <?php echo $badgesMargin; $badgesMargin-=$badgesSpacing?>px;" title="Pedido de confirmación del viaje enviado al chofer">
                <i class="glyphicon glyphicon-share-alt"></i>
            </span>
        </small>
    <?php endif?>
    
    <!-- TESTIMONIAL -->
    <?php if($conversation['TravelConversationMeta']['testimonial_requested']):?> 
        <small>
            <span class="label label-default info" style="float:left;margin-left: <?php echo $badgesMargin; $badgesMargin-=$badgesSpacing?>px;" title="Solicitud de testimonio enviada al viajero">
                <i class="glyphicon glyphicon-heart-empty"></i>
            </span>
        </small>
    <?php endif?>
    
    <!-- PINNED -->
    <?php if($conversation['TravelConversationMeta']['flag_type']):?>
        <small>
            <span class="label label-warning info" style="float:left;margin-left: <?php echo $badgesMargin; $badgesMargin-=$badgesSpacing?>px;" title="<b>Comentario Pin:</b><br/><?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $conversation['TravelConversationMeta']['flag_comment']);?>">
                <i class="glyphicon glyphicon-pushpin"></i>
            </span>
        </small>
    <?php endif?>
        
    <!-- ARCHIVADO -->
    <?php if(isset ($conversation['TravelConversationMeta']['archived'])):?>
        
        
        <div style="float:right;padding-right: 10px">
            <?php if($conversation['TravelConversationMeta']['archived']):?>
                <?php echo $this->Html->link('<i class="glyphicon glyphicon-export"></i>', array('controller'=>'driver_traveler_conversations', 'action'=>'unarchive/'.$thread['id']), array('escape'=>false, 'title'=>'Sacar del archivo', 'class'=>'info'))?>
            <?php endif?>

            <?php if(!$conversation['TravelConversationMeta']['archived'] && 
                        ( 
                            (isset ($conversation['Travel']) && TimeUtil::wasBefore('60 days', strtotime($conversation['Travel']['date'])))
                        ||
                            (isset ($conversation['Travel']) && $conversation['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_DONE && TimeUtil::wasBefore('15 days', strtotime($conversation['Travel']['date'])))
                        ) 
                    ):?>
                <?php echo $this->Html->link('<i class="glyphicon glyphicon-import"></i>', array('controller'=>'driver_traveler_conversations', 'action'=>'archive/'.$thread['id']), array('escape'=>false, 'title'=>'Archivar este viaje', 'class'=>'info text-danger'))?>
            <?php endif?>
        </div>
    <?php endif?>

<?php endif?>
    
<!-- NOTIFIED BY -->
<?php if(isset($thread['notified_by']) /*&& isset($userRole) && $userRole == 'admin'*/ && $thread['notified_by'] != null):?>
    <small>    
        <span class="info" style="float:left;margin-left: <?php echo $badgesMargin - strlen($thread['notified_by'])*5; $badgesMargin-=$badgesSpacing?>px;" title="Notificado por <?php echo $thread['notified_by'];if($thread['created'] != null) echo '<br/> el '.TimeUtil::prettyDate($thread['created'], false)?>">
            <code><?php echo $thread['notified_by']?></code>
        </span>
    </small>
<?php endif?>

<!-- COMMENTS -->
<?php if($showComments):?>
<div style="float:right;padding-right: 10px">
    <?php echo $this->element('travel_comments_controls', array('thread' => $thread, 'conversation'=>$conversation)); ?>
    &nbsp;
</div>
<?php endif?>

<!-- ARRANGEMENTS -->
<?php if(isset ($conversation['TravelConversationMeta']['arrangement']) && !empty($conversation['TravelConversationMeta']['arrangement'])):?>
<div style="float:right;padding-right: 10px">
    <span class="info" title="<b>Acuerdo:</b> <?php echo $conversation['TravelConversationMeta']['arrangement']?>"><i class="glyphicon glyphicon-link"></i></span>
</div>
<?php endif?>

<?php
// Cantidad total de mensajes
if($thread['message_count'] > 0): // Respondido ?> 
    <?php echo '<small><span class="label label-primary info" title="'.$thread['message_count'].' mensajes en total">'.$thread['message_count'].'</span></small>';?>
<?php endif?>

<?php if($hasMetadata):?>
    <!-- +1 -->
    <?php if($conversation['TravelConversationMeta']['read_entry_count'] < $thread['message_count']):?>
        <small><span class="label label-success info" title="<?php echo ($thread['message_count'] - $conversation['TravelConversationMeta']['read_entry_count'])?> nuevos mensajes">+<?php echo ($thread['message_count'] - $conversation['TravelConversationMeta']['read_entry_count'])?></span></small>
    <?php endif?>

    <!-- SIGUIENDO -->
    <?php if($conversation['TravelConversationMeta']['following']):?> 
        <small><span class="label label-info" style="margin-left:5px">Siguiendo</span></small>
    <?php endif?>

    <!-- ESTADOS -->
    <?php if($conversation['TravelConversationMeta']['state'] != DriverTravelerConversation::$STATE_NONE):?>
        <?php if($conversation['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_DONE):?>
            <small><span class="label label-warning" style="margin-left:5px"><i class="glyphicon glyphicon-thumbs-up"></i> Realizado</span></small>
        <?php elseif($conversation['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_PAID):?>
            <small><span class="label label-success" style="margin-left:5px"><i class="glyphicon glyphicon-usd"></i> Pagado</span></small>
        <?php endif?>
    <?php endif?>

<?php elseif($thread['message_count'] > 0):?>
    <!-- +1 -->
    <small><span class="label label-success info" title="<?php echo ($thread['message_count'])?> nuevos mensajes">+<?php echo ($thread['message_count'])?></span></small>
<?php endif?>
    
<!-- GANANCIAS -->
<?php 
if($hasMetadata && $conversation['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_PAID) 
    echo $this->element('travel_income_controls', array('thread' => $thread, 'conversation'=>$conversation));
?>