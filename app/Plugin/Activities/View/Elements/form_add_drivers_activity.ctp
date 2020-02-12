<div class="discountRides form">
<?php echo $this->Form->create('ActivityDriverSubscription',array('url' => array('plugin'=>'activities', 'controller' => 'activities', 'action' =>'add_drivers'),'class'=>'col-md-6 col-md-offset-3')); ?>
	<fieldset>
		<legend><?php echo __('Adicionar chofer a Actividad'); ?></legend>
                <div class="row">
                    <?php echo $this->Form->input('driver_id', array('type' => 'text', 'class'=>"driver-typeahead", 'label' => 'Chofer', 'required'=>true, 'placeholder'=>'Nombre, correo o provincia')); ?>
                </div>        
                 <?php echo $this->Form->input('activity_id', array('type' => 'hidden', 'value'=>$activity)); ?>
                <div class="row">
		<?php		
		echo $this->Form->input('price',array('label'=>'Oferta de precio'));		
	        ?>
                </div>
	</fieldset>
      <?php echo $this->Form->submit(__('Registrar'),array('class'=>'btn btn-info btn-md')); ?>
</div>