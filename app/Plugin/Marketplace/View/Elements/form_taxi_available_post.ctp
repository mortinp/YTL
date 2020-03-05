<?php App::uses('TaxiAvailablePost', 'Model');App::uses('TimeUtil', 'Util');?>

<div class="TaxiAvailablePost">
<?php echo $this->Form->create('TaxiAvailablePost', array('url' => array('action' =>'add'))); ?>
    <fieldset>
        <legend><?php echo __('Adicionar Taxi Disponible'); ?></legend>
        <br>
        <div class="row">
            <?php
            $localities = array();
            foreach (TaxiAvailablePost::$localities as $key => $l) {
                $localities[$key] = $l['name'];
            }
            ?>
            <div class="col-md-6">
                <?php echo $this->Form->input('origin_id', array('type'=>'select', 'options'=>$localities, 'label'=>'Origen')); ?>
            </div>
            <div class="col-md-6">
                <?php echo $this->Form->input('destination_id', array('type'=>'select', 'options'=>$localities, 'label'=>'Destino')); ?>             
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-4">
                <?php echo $this->Form->input('date',array('type'=>'text','class'=>'datepicker', 'label'=>'Fecha', 'autocomplete'=>'off'));?>
            </div> 
            
            <?php 
            $hours24 = array();
            for ($i = 1; $i <= 24; $i++) {
                $hours24[$i] = TimeUtil::getTimeAmPM($i);
            }
            ?>
            <div class="col-md-4 col-xs-6">
                <?php echo $this->Form->input('time_available_start', array('type'=>'select', 'options'=>$hours24, 'label'=>'Disponible a partir de:')); ?>
            </div>
            <div class="col-md-4 col-xs-6">
                <?php echo $this->Form->input('time_available_end', array('type'=>'select', 'options'=>array(-1=>'Opcional') + $hours24, 'label'=>'Disponible hasta:')); ?>                
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <?php echo $this->Form->input('max_pax', array('label' => __d('shared_travels', 'Máx. cantidad de pasajeros'), 'value'=>3 ,'type'=>'number', 'default' => 3, 'min' => 1));?>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <?php echo $this->Form->input('contact_name',array('label'=>'Nombre contacto'));?>
            </div>
            <div class="col-md-6">
                <?php echo $this->Form->input('contact_phone_number',array('label'=>'Teléfono'));?>
            </div>
        </div>
    </fieldset>
    <div class="row">
        <div class="col-md-12" style="padding-right: 40px">
            <?php echo $this->Form->submit(__('Registrar'),array('class'=>'btn btn-info btn-block')); ?>
        </div>
    </div>
    
</div>