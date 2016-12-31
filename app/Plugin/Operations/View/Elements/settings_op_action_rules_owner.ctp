<?php echo $this->element('Operations.widget_op_action_rule', array('rule'=>$rule))?>

<?php if($rule['OpActionRule']['allowed_by_owner']):?>
    <?php echo $this->Form->button('Quitar permiso', array('controller'=>'op_action_rules', 'action'=>'disallow/'.$rule['OpActionRule']['id'], 'class'=>'btn-sm btn-danger pull-right info', 'data-placement'=>'left', 'title'=>User::prettyName($rule['Other']).' ya no podrá '.OpActionRule::$rules[$rule['OpActionRule']['action_allowed']].' tuyos'), true)?>
<?php else:?>    
    <?php echo $this->Form->button('Permitir', array('controller'=>'op_action_rules', 'action'=>'allow/'.$rule['OpActionRule']['id'], 'class'=>'btn-sm btn-success pull-right info', 'data-placement'=>'left', 'title'=>User::prettyName($rule['Other']).' podrá '.OpActionRule::$rules[$rule['OpActionRule']['action_allowed']].' tuyos'), true)?>
<?php endif?>