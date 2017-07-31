<?php App::uses('CakeTime', 'Utility')?>
<?php App::uses('DriverTravelerConversation', 'Model')?>
<?php App::uses('TimeUtil', 'Util')?>

<?php
$months_es = array(__('Enero'), __('Febrero'), __('Marzo'), __('Abril'), __('Mayo'), __('Junio'), __('Julio'), __('Agosto'), __('Septiembre'), __('Octubre'), __('Noviembre'), __('Diciembre'));
$days_es = array(__('Domingo'), __('Lunes'), __('Martes'), __('Miércoles'), __('Jueves'), __('Viernes'), __('Sábado'));

$pretty_date = TimeUtil::prettyDate($travel['Travel']['date'], false);

$date_converted = strtotime($travel['Travel']['date']);
$expired = CakeTime::isPast($date_converted) && !CakeTime::isToday($date_converted);
?>


<?php 
$travelId = $travel['DriverTravel']['id'];
$travelDetails = $travel['Travel']['origin']. ' - '. $travel['Travel']['destination']
?>
<div>
    <span style="display: inline-block">
        <span><span class="text-muted">#</span><big><?php echo $travel['Travel']['id']?></big></span>
        &nbsp;
        <span class="h3"><?php echo $travelDetails?></span>
    </span>

    <?php
        $personW = __('persona');
        $pretty_people_count = $travel['Travel']['people_count']. ' ';
        if($travel['Travel']['people_count'] > 1) $pretty_people_count .= Inflector::pluralize ($personW);
        else $pretty_people_count .= $personW;
    ?>
    <div style="padding-top: 5px"> 
        <span class="text-muted"><?php echo $pretty_people_count?> <small><?php echo __('para el')?> </small><?php echo $pretty_date;?></span>
        <?php if($expired):?> <span class="badge"><?php echo __d('travel', 'Expirado')?></span><?php endif?>
    </div>
        
</div>
<br/>