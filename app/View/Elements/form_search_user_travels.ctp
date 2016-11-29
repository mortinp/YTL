<?php echo $this->Form->create('User', array('class'=>'navbar-form navbar-left','type'=>'GET', 'url'=>array('controller'=>'users', 'action'=>'search_travels_by_username'), 'target'=>'_blank')); ?>
<?php echo $this->Form->input('username', array('type'=>'text','label'=>false, 'class'=>'input-sm', 'placeholder'=>'Correo del usuario'));?>
<?php echo $this->Form->submit('Buscar Viajes', array('class'=>'btn btn-sm btn-default info','div'=>false, 'title'=>'Ver todos los viajes y conversaciones de un usuario'));?>
<?php echo $this->Form->end(); ?>
