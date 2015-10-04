<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <?php
        $src = '';
        if(Configure::read('debug') > 0) $src .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien
        $src .= '/'.str_replace('\\', '/', $profile['avatar_filepath']);
        ?>
        <div>
            <h1><img src="<?php echo $src?>"/> <span style="display: inline-block"><?php echo __d('driver_profile', 'Conoce a %s un poco más...', $profile['driver_name'])?></span></h1>
        </div>
        <hr/>
        
        <div style="font-size: 14pt">
            <?php echo $profile['description_'.Configure::read('Config.language')]?>
        </div>
    </div>
    <div class="col-md-8 col-md-offset-2" style="padding-top: 30px;">
    <?php if(AuthComponent::user('role') === 'admin'):?>
        <?php echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i> Editar este perfil', array('action'=>'edit_profile/'.$profile['driver_id']), array('escape'=>false))?>
    <?php endif?>
    </div>
</div>