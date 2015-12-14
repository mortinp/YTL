<div>
    <?php echo $this->Form->create('Driver', array('url' => array('controller' => 'travels', 'action' =>'notify_driver_travel/'.$travel_id))); ?>
    <fieldset>
        <?php
        echo $this->Form->input('driver_id', array('type' => 'text', 'class'=>'driver-typeahead', 'label' => __('Chofer'), 'required'=>true, 'value'=>''));        
        echo $this->Form->submit('Notificar');
        ?>
    </fieldset>
    <?php echo $this->Form->end(); ?>
</div>