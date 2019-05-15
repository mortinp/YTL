<div>
    <?php echo $this->Form->create('Travel', array('url' => array('controller' => 'travels', 'action' =>'edit_travel_data'))); ?>
    <fieldset>
        <?php        
        echo $this->Form->input('id', array('type' => 'hidden', 'value' => $data['Travel']['id']));
        echo $this->Form->input('people_count', array('type'=>'text','maxlength'=>'2', 'class'=>'form-control','style'=>'width:50px!important', 'label'=>'Nueva cantidad','value' => $data['Travel']['people_count']));
        echo $this->Form->submit('Cambiar', array('class'=>'btn btn-xs btn-primary'));
        ?>        
    </fieldset>
    <?php echo $this->Form->end(); ?>
</div>

