<?php app::uses('TimeUtil', 'Util'); ?>
<?php app::uses('EmailsUtil', 'Util'); ?>
        
<?php
    if($message['response_by'] == 'driver') {
        $label = (isset($driver_name)) ? $driver_name : __('Chofer');
        $color = "background-color: #d9edf7;";
    } else {
        $label = (isset($traveler_name)) ? $traveler_name : __('Viajero');
        $color = "background-color: #f5f5f5;";
    }
?>

<?php 
    $text = EmailsUtil::getFirsPart($message['response_text']);
    $daysPosted = TimeUtil::daysFrom($message['created']);
?>

<div style="<?php echo $color?>">
    <span><?php echo __('%s el %s, hace %s días', '<b>'.$label.'</b>', '<b>'.TimeUtil::prettyDate($message['created'], false).'</b>', $daysPosted) ?></span>
    
    <p><?php echo $text; ?></p>
</div>