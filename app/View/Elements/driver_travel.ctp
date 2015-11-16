<?php App::uses('CakeTime', 'Utility')?>
<?php App::uses('DriverTravelerConversation', 'Model')?>

<?php
$months_es = array(__('Enero'), __('Febrero'), __('Marzo'), __('Abril'), __('Mayo'), __('Junio'), __('Julio'), __('Agosto'), __('Septiembre'), __('Octubre'), __('Noviembre'), __('Diciembre'));
$days_es = array(__('Domingo'), __('Lunes'), __('Martes'), __('Miércoles'), __('Jueves'), __('Viernes'), __('Sábado'));

$date_converted = strtotime($driver_travel['Travel']['date']);
$day = date('j', $date_converted);
$month = $months_es[date('n', $date_converted) - 1];
$day_of_week = $days_es[date('w', $date_converted)];
$year = date('Y', $date_converted);
$pretty_date = $day.' '.$month.', '.$year.' ('.$day_of_week.')';

$expired = CakeTime::isPast($date_converted) && !CakeTime::isToday($date_converted);
if($expired) $pretty_date .= ' <span class="badge">Expirado</span>';
?>


<?php 
$conversationId = $driver_travel['DriverTravel']['id'];
$travelDetails = $driver_travel['Travel']['origin']. ' - '. $driver_travel['Travel']['destination']
?>
<div>
    <h2>
        <?php 
        if(isset ($driver_travel['Driver']['DriverProfile']) && $driver_travel['Driver']['DriverProfile'] != null && !empty ($driver_travel['Driver']['DriverProfile'])) :?>
            <?php
                $src = '';
                if(Configure::read('debug') > 0) $src .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien
                $src .= '/'.str_replace('\\', '/', $driver_travel['Driver']['DriverProfile']['avatar_filepath']);
            ?>
            <img src="<?php echo $src?>" title="<?php echo $driver_travel['Driver']['DriverProfile']['driver_name'].' - '.$driver_travel['Driver']['username']?>" style="max-height: 40px; max-width: 40px"/>
        <?php endif;?>
        <span style="display: inline-block"><small>#<?php echo $driver_travel['Travel']['id']?></small> <?php echo $travelDetails?> <small><small><?php echo $driver_travel['Travel']['User']['username']?></small></small></span>
    </h2>
</div>
<hr/>

<div>
    <?php 
    echo $this->Html->link($driver_travel['DriverTravel']['id'], array('controller'=>'driver_traveler_conversations', 'action'=>'view/'.$driver_travel['DriverTravel']['id']), array('title'=>$driver_travel['Driver']['username']));

    // Respondido
    $badgeOffset = -20;
    if($driver_travel['DriverTravel']['driver_traveler_conversation_count'] > 0) { // Respondido
        echo '<div style="float:left" title="Respondido ('.$driver_travel['DriverTravel']['driver_traveler_conversation_count'].' mensajes en total)"><i class="glyphicon glyphicon-star" style="margin-left: '.$badgeOffset.'px;"></i></div>';
        $badgeOffset -= 20;
    }
    
    $hasMetadata = (isset ($driver_travel['TravelConversationMeta']) && $driver_travel['TravelConversationMeta'] != null && !empty ($driver_travel['TravelConversationMeta']) && strlen(implode($driver_travel['TravelConversationMeta'])) != 0);
    
    ?>

    <?php if($hasMetadata):?>

        <!-- SIGUIENDO -->
        <?php if($driver_travel['TravelConversationMeta']['following']):?> 
            <span class="label label-info" style="margin-left:5px">Siguiendo</span>
        <?php endif?>

        <!-- +1 -->
        <?php if($driver_travel['TravelConversationMeta']['read_entry_count'] < $driver_travel['DriverTravel']['driver_traveler_conversation_count']):?>
            <span class="label label-success" style="margin-left:5px">+<?php echo ($driver_travel['DriverTravel']['driver_traveler_conversation_count'] - $driver_travel['TravelConversationMeta']['read_entry_count'])?></span>
        <?php endif?>

        <!-- ESTADOS -->
        <?php if($driver_travel['TravelConversationMeta']['state'] != DriverTravelerConversation::$STATE_NONE):?>
            <?php if($driver_travel['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_DONE):?>
                <span class="label label-warning" style="margin-left:5px" title="Viaje realizado"><i class="glyphicon glyphicon-thumbs-up"></i> Realizado</span>
            <?php elseif($driver_travel['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_PAID):?>
                <span class="label label-warning" style="margin-left:5px" title="Viaje pagado"><i class="glyphicon glyphicon-usd"></i> Pagado</span>
            <?php elseif($driver_travel['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_NOT_DONE):?>
                <span class="label label-danger" style="margin-left:5px" title="Viaje NO realizado"><i class="glyphicon glyphicon-thumbs-down"></i> NO realizado</span>
            <?php endif?>
        <?php endif?>

    <?php elseif($driver_travel['DriverTravel']['driver_traveler_conversation_count'] > 0):?>
        <span class="label label-success" style="margin-left:5px">+<?php echo ($driver_travel['DriverTravel']['driver_traveler_conversation_count'])?></span>

    <?php endif?>


    <!-- GANANCIAS -->
    <?php if($hasMetadata && $driver_travel['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_PAID):?>
        <?php if($driver_travel['TravelConversationMeta']['income'] != null && $driver_travel['TravelConversationMeta']['income'] != 0):?>
            <span class="label label-success" style="margin-left:5px" title="Ganancia"><i class="glyphicon glyphicon-usd"></i><?php echo $driver_travel['TravelConversationMeta']['income']?></span>
        <?php endif?>
        <?php if($driver_travel['TravelConversationMeta']['income_saving'] != null && $driver_travel['TravelConversationMeta']['income_saving'] != 0):?>
            <span class="label label-default" style="margin-left:5px" title="Ahorro"><i class="glyphicon glyphicon-usd"></i><?php echo $driver_travel['TravelConversationMeta']['income_saving']?></span>
        <?php endif?>
        
        <span id="income-set-<?php echo $conversationId?>">
            <a href="#!" class="edit-income-<?php echo $conversationId?>">&ndash; <?php echo __('poner ganancia')?></a>
        </span>
        <span id="income-cancel-<?php echo $conversationId?>" style="display:none">
            <a href="#!" class="cancel-edit-income-<?php echo $conversationId?>">&ndash; <?php echo __('cancelar')?></a>
        </span>
        <div id='income-form-<?php echo $conversationId?>' style="display:none">
            <br/>
            <?php echo $this->element('travel_income_form', array('data' => $driver_travel)); ?>
        </div>
    <?php endif?>
        
</div>

<div style="padding-top: 5px"> <?php echo 'Fecha del Viaje: '.$pretty_date;?></div>

<script type="text/javascript">
    $('.edit-income-<?php echo $conversationId?>, .cancel-edit-income-<?php echo $conversationId?>').click(function() {
        $('#income-form-<?php echo $conversationId?>, #income-set-<?php echo $conversationId?>, #income-cancel-<?php echo $conversationId?>').toggle();
    });
</script>