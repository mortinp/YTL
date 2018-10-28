<?php App::uses('CakeTime', 'Utility')?>
<?php App::uses('PendingTravel', 'Model')?>
<?php App::uses('TimeUtil', 'Util')?>

<?php
$hasPreferences = false;
foreach (Travel::getPreferences() as $key => $value) {
    if($travel['PendingTravel'][$key]) {
       $hasPreferences = true;
       break;
    }
}
?>

<p class="mbr-section-title mbr-bold pb-3 mbr-fonts-style display-5">
    <?php echo $travel['PendingTravel']['origin']?> <code>></code> <?php echo $travel['PendingTravel']['destination']?>
</p>
<hr>
<?php
$notice = array();
$notice['color'] = PendingTravel::getStateSettings($travel['PendingTravel']['state'], 'color');//Travel::$STATE[$travel['Travel']['state']]['color'];
$notice['label'] = PendingTravel::getStateSettings($travel['PendingTravel']['state'], 'label');//Travel::$STATE[$travel['Travel']['state']]['label'];
$notice['class'] = PendingTravel::getStateSettings($travel['PendingTravel']['state'], 'class');

?>
<p class="<?php echo $notice['class']?>" style="display: inline-block;font-size: 12pt" title="<?php echo __('Este viaje está ').$notice['label']?>">
    <?php echo $notice['label']?>
</p>
<p class="mbr-text pb-3 mbr-fonts-style display-7">
    <?php echo __d('mobirise/pending_travel', 'Fecha del viaje')?>: <strong><?php echo TimeUtil::prettyDate($travel['PendingTravel']['date'])?></strong><br>
    <?php echo __d('mobirise/pending_travel', 'Cantidad de personas')?>: <strong><?php echo $travel['PendingTravel']['people_count']?></strong>
    <br><br>
    <?php echo __d('mobirise/pending_travel', 'Detalles del viaje')?>:
    <blockquote><?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $travel['PendingTravel']['details'])?></blockquote>
    <?php if($hasPreferences):?>
        <?php echo __d('mobirise/pending_travel', 'Preferencias')?>: 
            <?php
                $sep = '';
                foreach (Travel::getPreferences() as $key => $value) {
                    if($travel['PendingTravel'][$key]) {
                        echo $sep.'<strong>'.$value.'</strong>';
                        $sep = ', ';
                    }
                }
             ?>
        <br>
    <?php endif?>
    <br>
    <?php echo __d('mobirise/pending_travel', 'Tu correo')?>: <strong><?php echo $travel['PendingTravel']['email']?></strong>
</p>