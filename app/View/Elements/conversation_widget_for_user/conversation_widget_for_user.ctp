<?php App::uses('CakeTime', 'Utility')?>
<?php App::uses('DriverTravelerConversation', 'Model')?>
<?php App::uses('TimeUtil', 'Util')?>

<?php
$months_es = array(__('Enero'), __('Febrero'), __('Marzo'), __('Abril'), __('Mayo'), __('Junio'), __('Julio'), __('Agosto'), __('Septiembre'), __('Octubre'), __('Noviembre'), __('Diciembre'));
$days_es = array(__('Domingo'), __('Lunes'), __('Martes'), __('Miércoles'), __('Jueves'), __('Viernes'), __('Sábado'));

$pretty_date = TimeUtil::prettyDate($conversation['Travel']['date'], false);

$date_converted = strtotime($conversation['Travel']['date']);
$expired = CakeTime::isPast($date_converted) && !CakeTime::isToday($date_converted);
?>


<?php 
$conversationId = $conversation['DriverTravel']['id'];
$travelDetails = $conversation['Travel']['origin']. ' - '. $conversation['Travel']['destination']
?>
<div>
    <?php 
    if(isset ($conversation['Driver']['DriverProfile']) && $conversation['Driver']['DriverProfile'] != null && !empty ($conversation['Driver']['DriverProfile'])) :?>
        <?php
            $src = '';
            if(Configure::read('debug') > 0) $src .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien
            $src .= '/'.str_replace('\\', '/', $conversation['Driver']['DriverProfile']['avatar_filepath']);
        ?>
        <img src="<?php echo $src?>" alt="<?php echo $conversation['Driver']['DriverProfile']['driver_name']?>" class="info" title="<?php echo $conversation['Driver']['DriverProfile']['driver_name']?>" style="max-height: 40px; max-width: 40px"/>
    <?php else:?>
        <img src="" class="info" title="No hay avatar para este chofer" style="max-height: 40px; max-width: 40px"/>
    <?php endif;?>
    <span style="display: inline-block">
        <span><span class="text-muted">#</span><big><big><?php echo $conversation['Travel']['id']?></big></big></span>
        &nbsp;
        <span class="h3"><?php echo $travelDetails?></span>
    </span>

    <?php
        $personW = __('persona');
        $pretty_people_count = $conversation['Travel']['people_count']. ' ';
        if($conversation['Travel']['people_count'] > 1) $pretty_people_count .= Inflector::pluralize ($personW);
        else $pretty_people_count .= $personW;
    ?>
    <div style="padding-top: 5px"> 
        <span class="text-muted"><?php echo $pretty_people_count?> <small><?php echo __('para el')?> </small><?php echo $pretty_date;?></span>
        <?php if($expired):?> <span class="badge"><?php echo __d('travel', 'Expirado')?></span><?php endif?>
    </div>
        
</div>
<br/>

<div>
    <?php echo $this->element('conversation_widget_for_user/conversation_id_decorated_for_user', array('conversation'=>$conversation))?>        
</div>