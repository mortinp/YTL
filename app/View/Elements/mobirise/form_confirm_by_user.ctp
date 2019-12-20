<?php echo $this->Session->flash();?>
<?php echo $this->Form->create('TravelConversationMeta', array('id' => 'CDirectForm', 'url' => array('controller' => 'driver_traveler_conversations',  'action'=>'confirm_travel'))); ?>
    <?php
    echo $this->Form->input('conversation_id', array('type' => 'hidden', 'value' => $conversation_id));
    echo $this->Form->custom_date('date_confirmed', array('label' => __('Nueva fecha de viaje (solo si cambia)'), 'dateFormat' => 'dd/mm/yyyy', 'class'=>'input-sm'));
    
   
    ?>

    <br>
    <span class="input-group-btn">
        <input type="submit" class="btn btn-primary btn-form btn-block display-5" id="CDirectSubmit" 
               value="<?php echo __d('default', 'CONFIRMAR VIAJE')?>"> 

    </span>

<?php echo $this->Form->end(); ?>