<span id="date-change-set-<?php echo $travel['DriverTravel']['id']?>" style="display: inline-block">
    <a href="#!" class="open-form edit-date-change-<?php echo $travel['DriverTravel']['id']?>" data-form="date-change-form-<?php echo $travel['DriverTravel']['id']?>">&ndash; <?php echo __('cambiar fecha')?></a>
</span>
<span id="date-change-cancel-<?php echo $travel['DriverTravel']['id']?>" style="display:none">
    <a href="#!" class="cancel-edit-date-change-<?php echo $travel['DriverTravel']['id']?>">&ndash; <?php echo __('cancelar')?></a>
</span>
<div id='date-change-form-<?php echo $travel['DriverTravel']['id']?>' style="display:none">
    <span class="alert alert-warning" style="display: inline-block"><i class="fa fa-warning"></i> Modificar la fecha solo si en las conversaciones se ha comprobado que el viaje es para una fecha distinta a la que el viajero había puesto en la solicitud.</span>
    <br/>
    <?php echo $this->Form->create('DriverTravel', array('url' => array('controller' => 'driver_travels', 'action' => 'change_date/'.$travel['DriverTravel']['id'])));?>
    <fieldset>
        <?php echo $this->Form->custom_date('travel_date', array('label' => 'Cambiar fecha', 'dateFormat' => 'dd/mm/yyyy', 'class'=>'input-sm'))?>
        <?php if($keepOriginal) echo $this->Form->input('original_date', array('type' => 'hidden', 'value' => CakeTime::format($originalDate, '%Y/%m/%d')))?>
        <?php echo $this->Form->submit('Cambiar')?>
    </fieldset>
    <?php echo $this->Form->end(); ?>
</div>