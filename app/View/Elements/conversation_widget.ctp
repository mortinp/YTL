<?php App::uses('CakeTime', 'Utility')?>
<?php App::uses('DriverTravelerConversation', 'Model')?>
<?php App::uses('TimeUtil', 'Util')?>
<?php App::uses('DriverTravel', 'Model')?>

<?php

$travelDate = DriverTravel::extractDate($conversation);
$pretty_date = TimeUtil::prettyDate($travelDate);
$date_converted = strtotime($travelDate);

$expired = CakeTime::isPast($date_converted) && !CakeTime::isToday($date_converted);
if($expired) $pretty_date .= ' <span class="badge">Expirado</span>';
?>

<div>
    <h2>
        <?php 
        if(isset ($conversation['Driver']['DriverProfile']) && $conversation['Driver']['DriverProfile'] != null && !empty ($conversation['Driver']['DriverProfile'])) :?>
            <?php
                $src = '';
                if(Configure::read('debug') > 0) $src .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien
                $src .= '/'.str_replace('\\', '/', $conversation['Driver']['DriverProfile']['avatar_filepath']);
            ?>
            <img src="<?php echo $src?>" alt="<?php echo $conversation['Driver']['DriverProfile']['driver_name']?>" class="info" title="<?php echo $conversation['Driver']['DriverProfile']['driver_name']?>" style="max-height: 40px; max-width: 40px"/>
        <?php endif;?>
        <span style="display: inline-block">
            <small>#<?php echo DriverTravel::getIdentifier($conversation); ?></small> 
            
            <?php if( isset($conversation['Travel']['id']) && $conversation['Travel']['id'] !== null): ?>                
                <?php echo $conversation['Travel']['origin']. ' - '. $conversation['Travel']['destination']; ?>
                <small><small>[<?php echo $conversation['Travel']['people_count']?> viajeros]</small></small>
            <?php endif;?>
                
            <small><small><?php echo $conversation['User']['username']?></small></small>
        </span> 
    </h2>
</div>
<hr/>

<div>
    <?php echo $this->element('conversation_id_decorated', array('conversation'=>$conversation))?>        
</div>

<div style="padding-top: 5px"> <?php echo 'Fecha del Viaje: '.$pretty_date;?></div>