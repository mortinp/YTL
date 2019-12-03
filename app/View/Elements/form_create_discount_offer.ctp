<?php
$driverId = null;
$driverIsSet = false; // Me dice si ya esta oferta se va a hacer para un chofer en especifico

if(isset($driver)) {
    if(isset($driver['Driver'])) $driver = $driver['Driver'];
    
    $driverId = $driver['id'];
    $driverIsSet = true;
}
?>

<div class="discountRides form">
<?php echo $this->Form->create('DiscountRide',array('url' => array('controller' => 'DiscountRides', 'action' =>'add'),'class'=>'col-md-6 col-md-offset-3')); ?>
	<fieldset>
		<legend><?php echo __('Adicionar viaje con descuento'); ?></legend>
                <div class="row">
                    <?php echo $this->Form->input('driver_id', array('type' => $driverIsSet?'hidden':'text', 'class'=>"driver-typeahead", 'label' => 'Chofer', 'required'=>true, 'value'=>$driverIsSet?$driverId:'', 'placeholder'=>'Nombre, correo o provincia')); ?>
                </div>
                <div class="row">
                   <?php echo $this->Form->input('origin',array('label'=>'Origen','placeholder'=>'Lugar, municipio o provincia'));
		    echo $this->Form->input('destination',array('label'=>'Destino','placeholder'=>'Lugar, municipio o provincia')); ?>
                </div>
                <div class="row">
                    <?php echo $this->Form->input('people_count',array('label'=>'Cantidad de viajeros','value'=>'4'));?>
                </div>
                <div class="row">
                    <?php echo $this->Form->input('date',array('type'=>'text','class'=>'datepicker','label'=>'Fecha'));?>
                </div> 
              
                <div class="row">
                    <div class="col-md-6" style="padding-left: 0px">
                        <label>Entre (Hora en formato 24H)</label>
                        <div class="input-group"><!--class clockpicker data-autoclose="true"-->
                            <?php echo $this->Form->input('hour_min',array('label'=>'')); ?>
                            <span class="input-group-addon">
                                <span class="fa fa-clock-o"></span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6" style="padding-right: 0px">
                        <label>Y</label>
                        <div class="input-group"><!--class clockpicker data-autoclose="true"-->
                            <?php echo $this->Form->input('hour_max',array('label'=>'')); ?>
                            <span class="input-group-addon">
                                <span class="fa fa-clock-o"></span>
                            </span>
                        </div>
                    </div>
                </div><br>
                <div class="row">
		<?php		
		echo $this->Form->input('price',array('label'=>'Oferta de precio'));		
	        ?>
                </div>
	</fieldset>
      <?php echo $this->Form->submit(__('Registrar'),array('class'=>'btn btn-info btn-md')); ?>
</div>