<style type="text/css">
    .btn-action {
        min-width: 120px;
    }
</style>

<div class="col-md-10 col-md-offset-1">
    <?php if(count($rules) == 0):?>No hay reglas<?php endif?>
    <?php foreach ($rules as $r): ?>
        <div class="col-md-8">
            <?php echo $this->element('widget_op_action_rule', array('rule'=>$r))?>
        </div>
        <div class="col-md-2">
            <?php if($r['OpActionRule']['allowed_by_owner']):?>
                <?php echo $this->Form->button('Quitar permiso', array('action'=>'disallow/'.$r['OpActionRule']['id'], 'class'=>'btn-sm btn-danger btn-action'), true)?>
            <?php else:?>    
                <?php echo $this->Form->button('Permitir', array('action'=>'allow/'.$r['OpActionRule']['id'], 'class'=>'btn-sm btn-success btn-action'), true)?>
            <?php endif?>
        </div>
        <div class="col-md-2">
            <?php if($r['OpActionRule']['accepted_by_other']):?>
                <?php echo $this->Form->button('Desactivar', array('action'=>'disactivate/'.$r['OpActionRule']['id'], 'class'=>'btn-sm btn-danger btn-action'), true)?>
            <?php else:?> 
                <?php echo $this->Form->button('Activar', array('action'=>'activate/'.$r['OpActionRule']['id'], 'class'=>'btn-sm btn-success btn-action'), true)?>
            <?php endif?>
        </div>
    <?php endforeach; ?>
</div>
    
<hr/>
    
<div class="col-md-8 col-md-offset-2"><?php echo $this->element('form_op_action_rule')?></div>
