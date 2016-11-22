<?php $this->request->data = $data // Esto es para que se muestren en el formulario los comentarios que ya existan?>
<div>
    <span class="bg-warning">¿Qué pasa con este viaje? ¿Hay problemas? ¿Te parece importante? Escribe en los comentarios cualquier nota que te permita saber por qué pineaste esta conversación.</span>
    <?php echo $this->Form->create('TravelConversationMeta', array('url' => array('controller' => 'driver_traveler_conversations', 'action' =>'pin/'.$data['DriverTravel']['id']))); ?>
    <fieldset>
        <?php
        //echo $this->Form->input('conversation_id', array('type'=>'hidden'));
        echo $this->Form->input('flag_comment', array('type'=>'textarea', 'label'=>'Comentarios'));
        echo $this->Form->submit('Pinear conversación con estos comentarios');
        ?>
    </fieldset>
    <?php echo $this->Form->end(); ?>
</div>