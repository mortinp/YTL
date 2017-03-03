<?php echo $this->Form->create('Search', array('class'=>'navbar-form navbar-left','type'=>'GET', 'url'=>array('controller'=>'search', 'action' => 'index'), 'target'=>'_blank')); ?>
<?php echo $this->Form->input('q', array('type'=>'text','label'=>false, 'class'=>'input-sm', 'placeholder'=>'id del viaje o correo del usuario'));?>
<?php echo $this->Form->submit('Buscar Viajes', array('class'=>'btn btn-sm btn-default info','div'=>false, 'title'=>'Buscar viajes según su número o el correo del usuario'));?>
<?php echo $this->Form->end(); ?>