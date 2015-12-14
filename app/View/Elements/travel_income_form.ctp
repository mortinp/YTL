<div>
    <?php echo $this->Form->create('TravelConversationMeta', array('url' => array('controller' => 'driver_traveler_conversations', 'action' =>'set_income/'.$data['TravelConversationMeta']['conversation_id']))); ?>
    <fieldset>
        <?php
        echo $this->Form->input('conversation_id', array('type'=>'hidden'));
        echo $this->Form->input('income', array('type'=>'text', 'class'=>'input-sm', 'label'=>'Total del viaje'));
        echo $this->Form->input('income_saving', array('type'=>'text', 'class'=>'input-sm', 'label'=>'Ahorro de YoTeLlevo'));
        echo $this->Form->submit('Salvar');        
        ?>
    </fieldset>
    <?php echo $this->Form->end(); ?>
</div>