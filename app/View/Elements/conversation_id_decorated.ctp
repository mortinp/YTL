<?php 
if(isset ($conversation['DriverTravel'])) 
    $thread = $conversation['DriverTravel'];
else $thread = $conversation;
?>

<?php 
$info = array();
if(isset ($conversation['Driver'])) $info['title'] = $conversation['Driver']['username'];
echo $this->Html->link($thread['id'], array('controller'=>'driver_traveler_conversations', 'action'=>'view/'.$thread['id']), $info);

// Respondido
$badgeOffset = -30;
if($thread['driver_traveler_conversation_count'] > 0) { // Respondido
    echo '<div style="float:left" title="'.$thread['driver_traveler_conversation_count'].' mensajes en total"><div class="label label-primary" style="margin-left: '.$badgeOffset.'px;">'.$thread['driver_traveler_conversation_count'].'</div></div>';
    $badgeOffset -= 30;
}

$hasMetadata = (isset ($conversation['TravelConversationMeta']) && $conversation['TravelConversationMeta'] != null && !empty ($conversation['TravelConversationMeta']) && strlen(implode($conversation['TravelConversationMeta'])) != 0);

?>

<?php if($hasMetadata):?>

    <!-- SIGUIENDO -->
    <?php if($conversation['TravelConversationMeta']['following']):?> 
        <span class="label label-info" style="margin-left:5px">Siguiendo</span>
    <?php endif?>

    <!-- +1 -->
    <?php if($conversation['TravelConversationMeta']['read_entry_count'] < $thread['driver_traveler_conversation_count']):?>
        <span class="label label-success" style="margin-left:5px">+<?php echo ($thread['driver_traveler_conversation_count'] - $conversation['TravelConversationMeta']['read_entry_count'])?></span>
    <?php endif?>

    <!-- ESTADOS -->
    <?php if($conversation['TravelConversationMeta']['state'] != DriverTravelerConversation::$STATE_NONE):?>
        <?php if($conversation['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_DONE):?>
            <span class="label label-warning" style="margin-left:5px" title="Viaje realizado"><i class="glyphicon glyphicon-thumbs-up"></i> Realizado</span>
        <?php elseif($conversation['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_PAID):?>
            <span class="label label-warning" style="margin-left:5px" title="Viaje pagado"><i class="glyphicon glyphicon-usd"></i> Pagado</span>
        <?php elseif($conversation['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_NOT_DONE):?>
            <span class="label label-danger" style="margin-left:5px" title="Viaje NO realizado"><i class="glyphicon glyphicon-thumbs-down"></i> NO realizado</span>
        <?php endif?>
    <?php endif?>

<?php elseif($thread['driver_traveler_conversation_count'] > 0):?>
    <span class="label label-success" style="margin-left:5px">+<?php echo ($thread['driver_traveler_conversation_count'])?></span>

<?php endif?>


<!-- GANANCIAS -->
<?php if($hasMetadata && $conversation['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_PAID):?>
    <?php if($conversation['TravelConversationMeta']['income'] != null && $conversation['TravelConversationMeta']['income'] != 0):?>
        <span class="label label-success" style="margin-left:5px" title="Ganancia"><i class="glyphicon glyphicon-usd"></i><?php echo $conversation['TravelConversationMeta']['income']?></span>
    <?php endif?>
    <?php if($conversation['TravelConversationMeta']['income_saving'] != null && $conversation['TravelConversationMeta']['income_saving'] != 0):?>
        <span class="label label-default" style="margin-left:5px" title="Ahorro"><i class="glyphicon glyphicon-usd"></i><?php echo $conversation['TravelConversationMeta']['income_saving']?></span>
    <?php endif?>

    <span id="income-set-<?php echo $thread['id']?>" style="display: inline-block">
        <a href="#!" class="edit-income-<?php echo $thread['id']?>">&ndash; <?php echo __('poner ganancia')?></a>
    </span>
    <span id="income-cancel-<?php echo $thread['id']?>" style="display:none">
        <a href="#!" class="cancel-edit-income-<?php echo $thread['id']?>">&ndash; <?php echo __('cancelar')?></a>
    </span>
    <div id='income-form-<?php echo $thread['id']?>' style="display:none">
        <br/>
        <?php echo $this->element('travel_income_form', array('data' => $conversation)); ?>
    </div>
<?php endif?>

<script type="text/javascript">
    $('.edit-income-<?php echo $thread['id']?>, .cancel-edit-income-<?php echo $thread['id']?>').click(function() {
        $('#income-form-<?php echo $thread['id']?>, #income-set-<?php echo $thread['id']?>, #income-cancel-<?php echo $thread['id']?>').toggle();
    });
</script>