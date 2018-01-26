<?php
$modalityCode = $request['SharedTravel']['modality_code'];
$modality = SharedTravel::$modalities[$modalityCode];
?>
<div class="container">
    <div class="row" style="margin-top: 40px">
        <div class="col-md-8 col-md-offset-2">
            <?php echo __d('shared_travels', 'Transfer desde %s hasta %s el %s', '<code><big>'.$modality['origin'].'</big></code>', '<code><big>'.$modality['destination'].'</big></code>', '<code><big>'.TimeUtil::prettyDate($request['SharedTravel']['date'], false).'</big></code>')?>
            <hr/>
        </div>
        <div class="col-md-8 col-md-offset-2">
            <?php echo $this->element('shared_travel', compact('request') + array('showDetails'=>true))?>
            
            <hr/>
            <div><?php echo $this->Html->link(
                    'Cancelar', 
                    array('controller'=>'shared-rides', 'action'=>'cancel/'.$request['SharedTravel']['id_token']),
                    array('class'=>'btn btn-danger', 'confirm'=>'¿Está seguro que quiere cancelar esta solicitud?'))?></div>
            <br/>
            <div><b>Código Activación:</b> <?php echo $request['SharedTravel']['activation_token']?></div>
            <br/>
            <?php $fechaCambiada = isset ($request['SharedTravel']['original_date']) && $request['SharedTravel']['original_date'] != null;?>
            <div class="alert alert-success" style="display: inline-block; margin-bottom: 0px">
                <?php if($fechaCambiada):?><span class="badge"><b><?php echo TimeUtil::prettyDate($request['SharedTravel']['original_date'])?></b></span><?php endif?>
                <b><?php echo TimeUtil::prettyDate($request['SharedTravel']['date'])?></b>
                <?php echo $this->element('form_shared_travel_date_controls', array('request'=>$request, 'keepOriginal'=>!$fechaCambiada, 'originalDate'=>strtotime($request['SharedTravel']['date'])))?>
            </div>
        </div>
    </div>
</div>