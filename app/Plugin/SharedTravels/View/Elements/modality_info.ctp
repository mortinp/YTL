<div>
<?php 
echo __d('shared_travels', '%s - %s', '<code><big>'.$modality['origin'].'</big></code>', '<code><big><big><big>'.$modality['destination'].'</big></big></big></code>')
?>
</div>
<div><?php echo __d('shared_travels', 'Hora de recogida %s', '<code><big><big><big>'.$modality['time'].'</big></big></big></code>')?></div>
<div><?php echo __d('shared_travels', '%s por persona', '<code><big><big>'.$modality['price'].' cuc'.'</big></big></code>')?></div>
<br/>
<div><?php echo $this->Html->link(__d('shared_travels', 'Solicitar este transfer'), array('controller'=>'shared-rides', 'action'=>'create?s='.$code.'#request-ride'), array('class'=>'btn btn-block btn-info'))?></div>

<!--<div>
    <a class="btn btn-block btn-info open-modal" data-modal="info-<?php /*echo $code*/?>" href="/shared-rides/create?s=<?php echo $code?>#request-ride">
        <?php /*echo __d('shared_travels', 'Solicitar este transfer')*/?>
    </a>
</div>
<div style="display: none" id="info-<?php /*echo $code*/?>">
    <?php /*echo $this->element('shared_travel_form_all', compact('modality') + compact('code'))*/?>
</div>-->