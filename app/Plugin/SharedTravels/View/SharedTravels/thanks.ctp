<?php
$modalityCode = $request['SharedTravel']['modality_code'];
$modality = SharedTravel::$modalities[$modalityCode];
?>
<div class="container">
    <div class="row" style="margin-top: 40px">
        <div class="col-md-8 col-md-offset-2">
            <p class="lead"><?php echo __d('shared_travels', 'Muchísimas gracias').'! '.__d('shared_travels', 'Ya tenemos tu solicitud de transfer.')?></p> 
            <p class="lead"><?php echo __d('shared_travels', '%s personas desde %s hasta %s el %s a las %s.', '<code><big>'.$request['SharedTravel']['people_count'].'</big></code>', '<code><big>'.$modality['origin'].'</big></code>', '<code><big>'.$modality['destination'].'</big></code>', '<code><big>'.TimeUtil::prettyDate($request['SharedTravel']['date'], false).'</big></code>', '<code><big>'.$modality['time'].'</big></code>')?></p> 
            <p><?php echo __d('shared_travels', 'Te enviamos un correo a %s con un enlace para confirmar la solicitud.', '<b>'.$request['SharedTravel']['email'].'</b>').' '.__d('shared_travels', 'Debes confirmarla para nosotros comenzar a arreglar todo.')?></p>
            <p><?php echo __d('shared_travels', 'Estos son todos los datos de tu solicitud')?>:</p>
        </div>
        
        <div class="col-md-8 col-md-offset-2">
            <hr/>
            <?php echo $this->element('shared_travel', compact('request'))?>
        </div>
    </div>
</div>