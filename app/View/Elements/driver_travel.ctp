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





<?php $travelDetails = $driver_travel['Travel']['origin']. ' - '. $driver_travel['Travel']['destination']?>
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
        <span style="display: inline-block"><?php echo $travelDetails?> <small><small><?php echo $driver_travel['Travel']['User']['username']?></small></small></span>
    </h2>
</div>
<hr/>

<div>
<?php 
echo $this->Html->link($driver_travel['DriverTravel']['id'], array('controller'=>'driver_traveler_conversations', 'action'=>'view/'.$driver_travel['DriverTravel']['id']), array('title'=>$driver_travel['Driver']['username']));

$sent = $driver_travel;
            
// Respondido
$badgeOffset = -20;
if($sent['DriverTravel']['driver_traveler_conversation_count'] > 0) { // Respondido
    echo '<div style="float:left" title="Respondido ('.$sent['DriverTravel']['driver_traveler_conversation_count'].' mensajes en total)"><i class="glyphicon glyphicon-star" style="margin-left: '.$badgeOffset.'px;"></i></div>';
    $badgeOffset -= 20;
}            

if(isset ($sent['TravelConversationMeta']) && $sent['TravelConversationMeta'] != null && !empty ($sent['TravelConversationMeta']) && strlen(implode($sent['TravelConversationMeta'])) != 0) {
    // Siguiendo
    if($sent['TravelConversationMeta']['following']) echo '<span class="label label-info" style="margin-left:5px">Siguiendo</span>';

    // +1
    if($sent['TravelConversationMeta']['read_entry_count'] < $sent['DriverTravel']['driver_traveler_conversation_count']) 
        echo '<span class="label label-success" style="margin-left:5px">+'.($sent['DriverTravel']['driver_traveler_conversation_count'] - $sent['TravelConversationMeta']['read_entry_count']).'</span>';

    // Estado
    if($sent['TravelConversationMeta']['state'] != DriverTravelerConversation::$STATE_NONE) {
        if($sent['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_DONE) 
            echo '<span class="label label-warning" style="margin-left:5px" title="Viaje realizado"><i class="glyphicon glyphicon-thumbs-up"></i> Realizado</span>';
        else if($sent['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_PAID)
            echo '<span class="label label-warning" style="margin-left:5px" title="Viaje pagado"><i class="glyphicon glyphicon-usd"></i> Pagado</span>';
        else if($sent['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_NOT_DONE)
            echo '<span class="label label-danger" style="margin-left:5px" title="Viaje NO realizado"><i class="glyphicon glyphicon-thumbs-down"></i> NO realizado</span>';
    }
} else {
    // +1
    if($sent['DriverTravel']['driver_traveler_conversation_count'] > 0) 
        echo '<span class="label label-success" style="margin-left:5px">+'.($sent['DriverTravel']['driver_traveler_conversation_count']).'</span>';
} 
?>

<br/>

<div style="padding-top: 5px">
<?php 
echo 'Fecha del Viaje: '.$pretty_date;
?>
</div>
    
</div>