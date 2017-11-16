<?php
// Verificar si hay transfers desde el destino
$suggestTransfers = false;
foreach (SharedTravel::$modalities as $code=>$mod)
    if($mod['origin_id'] == $modality['destination_id'] /*&& $mod['destination_id'] != $modality['origin_id']*/) {
        $suggestTransfers = true; break;
    }
?>

<?php if($suggestTransfers):?>

<p style="text-align: center"><b><?php echo __d('shared_travels', 'SOLICITA OTROS TRANSFERS PARA EL RESTO DE TU VIAJE')?></b></p><hr/>
<ul class="list-unstyled">
    <?php foreach (SharedTravel::$modalities as $code=>$mod):?>
        <?php if($mod['origin_id'] == $modality['destination_id'] /*&& $mod['destination_id'] != $modality['origin_id']*/):?>
            <li style="padding-top: 5px"><?php echo $this->Html->link(__d('shared_travels', '%s - %s, %s','<b>'.$mod['origin'].'</b>', '<b>'.$mod['destination'].'</b>', '<b>'.$mod['time'].'</b>'), array('action'=>'create?s='.$code.'#request-ride'), array('escape'=>false, 'style'=>'color:inherit'))?></li>
        <?php endif;?>
    <?php endforeach;?>
</ul>
<hr/>
<?php echo $this->Html->link(__d('shared_travels', 'VER RUTAS DISPONIBLES'), array('controller'=>'shared-rides', 'action'=>'home#transfers-available'), array('class'=>'btn btn-block btn-info'))?>
<?php endif;?>