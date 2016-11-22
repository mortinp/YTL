<div>  
    <span id="date-change-set-<?php echo $travel['Travel']['id']?>" style="display: inline-block">
        <a href="#!" class="open-form edit-date-change-<?php echo $travel['Travel']['id']?>" data-form="date-change-form-<?php echo $travel['Travel']['id']?>">&ndash; <?php echo __('cambiar fecha')?></a>
    </span>
    <span id="date-change-cancel-<?php echo $travel['Travel']['id']?>" style="display:none">
        <a href="#!" class="cancel-edit-date-change-<?php echo $travel['Travel']['id']?>">&ndash; <?php echo __('cancelar')?></a>
    </span>
    <div id='date-change-form-<?php echo $travel['Travel']['id']?>' style="display:none">
        <span class="alert alert-warning" style="display: inline-block"><i class="glyphicon glyphicon-warning-sign"></i> Modificar la fecha solo si en las conversaciones se ha comprobado que el viaje es para una fecha distinta a la que el viajero había puesto en la solicitud.</span>
        <br/>
        <?php echo $this->Form->create('Travel', array('url' => array('controller' => 'travels', 'action' => 'edit_travel_data/'.$travel['Travel']['id'].'/0')));?>
        <fieldset>
            <?php echo $this->Form->custom_date('date', array('label' => 'Cambiar fecha', 'dateFormat' => 'dd/mm/yyyy', 'class'=>'input-sm'))?>
            <?php if($keepOriginal) echo $this->Form->input('original_date', array('type' => 'hidden', 'value' => CakeTime::format($originalDate, '%Y/%m/%d')))?>
            <?php echo $this->Form->submit('Cambiar')?>
        </fieldset>
        <?php echo $this->Form->end(); ?>
    </div>
</div>