<?php
if(!isset ($doBootbox)) $doBootbox = false;
?>

<div>
<?php 
echo __d('shared_travels', '%s - %s', '<code><big>'.$modality['origin'].'</big></code>', '<code><big><big><big>'.$modality['destination'].'</big></big></big></code>')
?>
</div>
<div><?php echo __d('shared_travels', 'Hora de recogida %s', '<code><big><big><big>'.$modality['time'].'</big></big></big></code>')?></div>
<div><?php echo __d('shared_travels', '%s por persona', '<code><big>'.$modality['price'].' cuc'.'</big></code>')?></div>
<div><?php echo __d('shared_travels', '<span class="text-muted"><small>- mejor que</small></span> <s>%s</s> <span class="text-muted"><small>por viaje privado -</small></span>', '<code><big><big>$'.(4*$modality['price']).'</big></big></code>')?></div>
<br/>

<?php if(!$doBootbox):?>
    <div><?php echo $this->Html->link(__d('shared_travels', '<big>Compartir este viaje</big> <div>y pagar sólo <b>%s</b> por persona</div>', $modality['price']. ' cuc'), array('controller'=>'shared-rides', 'action'=>'create?s='.$code.'#request-ride'), array('class'=>'btn btn-block btn-info', 'style'=>'white-space: normal;', 'escape'=>false))?></div>
<?php else:?>
    <div>
        <?php echo $this->Html->link(__d('shared_travels', '<big>Compartir este viaje</big> <div>y pagar sólo <b>%s</b> por persona</div>', $modality['price']. ' cuc'), array('controller'=>'shared-rides', 'action'=>'create?s='.$code.'#request-ride'), array('data-modal'=>'info-'.$code, 'class'=>'btn btn-block btn-info open-modal', 'style'=>'white-space: normal;', 'escape'=>false))?>
    </div>
    <div style="display: none" id="info-<?php echo $code?>">
        <?php echo $this->element('shared_travel_book_bootbox', compact('modality') + compact('code'))?>
    </div>
<?php endif?>