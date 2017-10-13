<?php
$modalityCode = $request['SharedTravel']['modality_code'];
$modality = SharedTravel::$modalities[$modalityCode];
?>
<div class="container">
    <div class="row" style="margin-top: 40px">
        <div class="col-md-8 col-md-offset-1">
            <p class="lead"><?php echo __d('shared_travels', 'Muchas gracias %s', $request['SharedTravel']['name_id'])?>!</p> 
            <p class="lead"><?php echo __d('shared_travels', 'Nuestros operadores acaban de recibir los datos de tu solicitud y enseguida empiezan a organizar todo. En menos de 24 horas recibirás la confirmación.')?></p> 
            <p><?php echo __d('shared_travels', 'En cuanto todo esté listo recibirás un correo de tu operador asistente, con quien quedarás en contacto mientras llega la fecha del servicio.')?></p>
            <p><?php echo __d('shared_travels', 'Estos son todos los datos de tu solicitud')?>:</p>
        </div>
        
        <div class="col-md-8 col-md-offset-1">
            <hr/>
            <?php echo $this->element('shared_travel', compact('request'))?>
        </div>
        
        <?php
        // Verificar si hay transfers desde el destino
        $suggestTransfers = false;
        foreach (SharedTravel::$modalities as $code=>$mod)
            if($mod['origin_id'] == $modality['destination_id'] /*&& $mod['destination_id'] != $modality['origin_id']*/) {
                $suggestTransfers = true; break;
            }
        ?>
        
        <?php if($suggestTransfers):?>
        <div class="col-md-3 alert alert-warning" style="display: inline-block">
            <p style="text-align: center"><b><?php echo __d('shared_travels', 'SOLICITA OTROS TRANSFERS PARA EL RESTO DE TU VIAJE')?></b></p><hr/>
            <ul class="list-unstyled">
                <?php foreach (SharedTravel::$modalities as $code=>$mod):?>
                    <?php if($mod['origin_id'] == $modality['destination_id'] /*&& $mod['destination_id'] != $modality['origin_id']*/):?>
                        <li style="padding-top: 5px"><?php echo $this->Html->link(__d('shared_travels', '%s - %s, %s','<b>'.$mod['origin'].'</b>', '<b>'.$mod['destination'].'</b>', '<b>'.$mod['time'].'</b>'), array('action'=>'create?s='.$code.'&highlight=request-ride'), array('escape'=>false, 'style'=>'color:inherit'))?></li>
                    <?php endif;?>
                <?php endforeach;?>
            </ul>
        </div>
        <?php endif;?>
        
    </div>
</div>