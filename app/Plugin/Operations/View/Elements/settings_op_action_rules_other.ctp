<?php echo $this->element('Operations.widget_op_action_rule', array('rule'=>$rule))?>

<?php if($rule['OpActionRule']['accepted_by_other']):?>
    <?php echo $this->Form->button('Desactivar', array('controller'=>'op_action_rules', 'action'=>'disactivate/'.$rule['OpActionRule']['id'], 'class'=>'btn-sm btn-danger pull-right info', 'data-placement'=>'left', 'title'=>'Ya no podrás '.OpActionRule::$rules[$rule['OpActionRule']['action_allowed']].' de '.User::prettyName($rule['Owner'])), true)?>
<?php else:?> 
    <?php echo $this->Form->button('Activar', array('controller'=>'op_action_rules', 'action'=>'activate/'.$rule['OpActionRule']['id'], 'class'=>'btn-sm btn-success pull-right info', 'data-placement'=>'left', 'title'=>'Podrás '.OpActionRule::$rules[$rule['OpActionRule']['action_allowed']].' de '.User::prettyName($rule['Owner'])), true)?>
<?php endif?>