<?php echo $this->Form->create('OpActionRule', array('url'=>array('action'=>'add'), 'class'=>'form-inline')); ?>
<fieldset>
    <?php 
    echo $this->Form->input('op_owner', array('type' => 'select', 'options' => $operators, 'label' => false));
    echo ' le permite a ';
    echo $this->Form->input('op_other', array('type' => 'select', 'options' => $operators, 'label' => false));
    echo '&nbsp;';
    echo $this->Form->input('action_allowed', array(
        'label'=>false,
        'options' => OpActionRule::$rules
    ));
    echo '&nbsp;';
    echo $this->Form->checkbox('allowed_by_owner').' Permitido ';
    echo $this->Form->checkbox('accepted_by_other').' Aceptado';
    echo '<br/><br/>';
    echo $this->Form->submit('Adicionar Regla');
    ?>
</fieldset>
<?php echo $this->Form->end(); ?>