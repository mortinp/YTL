<?php $this->request->data = $data // Esto es para que se muestren en el formulario los comentarios que ya existan?>
<div>
    <?php echo $this->Form->create('TravelConversationMeta', array('url' => array('controller' => 'driver_traveler_conversations', 'action' =>'update_meta_field/'.$data['DriverTravel']['id']))); ?>
    <fieldset>
        <?php
        echo $this->Form->input('conversation_id', array('type'=>'hidden'));
        echo $this->Form->input('comments', array('type'=>'textarea', 'class'=>'input-sm', 'label'=>'Comentarios'));
        echo $this->Form->submit('Guardar Comentarios');
        ?>
    </fieldset>
    <?php echo $this->Form->end(); ?>
</div>