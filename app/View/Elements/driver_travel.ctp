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
        <span style="display: inline-block">
            <small>#<?php echo $driver_travel['Travel']['id']?></small> 
            <?php echo $travelDetails?>
            <small><small>[<?php echo $driver_travel['Travel']['people_count']?> viajeros]</small></small>
            <small><small><?php echo $driver_travel['Travel']['User']['username']?></small></small>
        </span>
    </h2>
</div>
<hr/>

<div>
    <?php echo $this->element('conversation_id_decorated', array('conversation'=>$driver_travel))?>        
</div>

<div style="padding-top: 5px"> <?php echo 'Fecha del Viaje: '.$pretty_date;?></div>