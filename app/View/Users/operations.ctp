<?php if(AuthComponent::user('role') != 'operator') return ?>

<div class="container-fluid">
    <div class="col-md-8 col-md-offset-2">
        <?php if(count($op_rules_own) > 0):?><legend>Operaciones que puedes permitir a otros operadores</legend><?php endif?>
        <?php foreach ($op_rules_own as $r): ?>
            <p><?php echo $this->element('Operations.settings_op_action_rules_owner', array('rule'=>$r))?></p>
        <?php endforeach; ?>

        <br/>
        <hr/>

        <?php if(count($op_rules_others_allow) > 0):?><legend>Operaciones que otros operadores te permiten y que puedes activar</legend><?php endif?>
        <?php foreach ($op_rules_others_allow as $r): ?>
            <p><?php echo $this->element('Operations.settings_op_action_rules_other', array('rule'=>$r))?></p>
        <?php endforeach; ?>
    </div>
</div>
