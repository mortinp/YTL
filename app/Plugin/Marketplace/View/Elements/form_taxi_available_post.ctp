<?php App::uses('TaxiAvailablePost', 'Model');App::uses('TimeUtil', 'Util');?>

<div class="TaxiAvailablePost">
<?php echo $this->Form->create('TaxiAvailablePost', array('url' => array('action' =>'add'))); ?>
    <fieldset>
        <legend><?php echo __('Adicionar Taxi Disponible'); ?></legend>
        <br>
        <div class="row">
            <?php echo $this->Form->input('origin_id', array('type'=>'select', 'options'=>TaxiAvailablePost::$localities, 'label'=>'Origen')); ?>
            <?php echo $this->Form->input('destination_id', array('type'=>'select', 'options'=>TaxiAvailablePost::$localities, 'label'=>'Destino')); ?>
        </div>
        <br>
        <div class="row">
            <?php echo $this->Form->input('max_pax', array('label' => __d('shared_travels', 'Máx. cantidad de pasajeros'), 'value'=>3 ,'type'=>'number', 'default' => 3, 'min' => 1));?>
        </div>
        <br>
        <div class="row">
            <?php echo $this->Form->input('date',array('type'=>'text','class'=>'datepicker', 'label'=>'Fecha', 'autocomplete'=>'off'));?>
        </div>

        <div class="row">
            <?php 
            $hours24 = array();
            for ($i = 1; $i <= 24; $i++) {
                $hours24[$i] = TimeUtil::getTimeAmPM($i);
            }
            ?>
            
            <div class="col-md-6" style="padding-left: 0px">
                <?php echo $this->Form->input('time_available_start', array('type'=>'select', 'options'=>$hours24, 'label'=>'Disponible a partir de:')); ?>
            </div>
            <div class="col-md-6" style="padding-right: 0px">
                <?php echo $this->Form->input('time_available_end', array('type'=>'select', 'options'=>array(-1=>'Opcional') + $hours24, 'label'=>'Disponible hasta:')); ?>                
            </div>
        </div>
        <br>
        <div class="row">
            <?php echo $this->Form->input('contact_name',array('label'=>'Nombre contacto'));?>
            <?php echo $this->Form->input('contact_phone_number',array('label'=>'Teléfono'));?>
        </div>
    </fieldset>
    <?php echo $this->Form->submit(__('Registrar'),array('class'=>'btn btn-info btn-block')); ?>
</div>