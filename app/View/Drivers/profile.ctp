<div class="row">
    <div class="col-md-8 <?php if($userLoggedIn):?>col-md-offset-2<?php else:?>col-md-offset-1<?php endif?>">
        <?php
        $src = '';
        if(Configure::read('debug') > 0) $src .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien
        $src .= '/'.str_replace('\\', '/', $profile['DriverProfile']['avatar_filepath']);
        ?>
        <div>
            <h1><img src="<?php echo $src?>"/> <span style="display: inline-block"><?php echo __d('driver_profile', 'Conoce a %s un poco más...', $profile['DriverProfile']['driver_name'])?></span></h1>
        </div>
        <hr/>
        
        <div class="lead">
            <?php echo $profile['DriverProfile']['description_'.Configure::read('Config.language')]?>
        </div>
    </div>
    
    <?php if(!$userLoggedIn):?>
    <div class="col-md-2">
        <span class="alert alert-info" style="display: inline-block;width: 100%;text-align: center">
            <h2><p style="text-align: center"><?php echo __d('driver_profile', '¿Necesitas un chofer con auto en Cuba?')?></p></h2>

            <div><?php echo __d('driver_profile', 'Contacta con varios de nuestros choferes desde nuestra página de inicio')?></div>
            <br/>
            <?php echo $this->Html->link('<big>'.__d('driver_profile', 'Contactar choferes').'</big>', '/?from=driver-profile-'.$profile['Driver']['id'], array('class'=>'btn btn-info btn-block', 'escape'=>false));?>

            <br/>
            <div>...<?php echo __d('driver_profile', 'o entra al sitio para gestionar tus viajes')?></div>
            <br/>
            <?php echo $this->Html->link(__d('driver_profile', 'Entrar al sitio'), array('controller'=>'users', 'action'=>'login'), array('class'=>'btn btn-default btn-block', 'escape'=>false));?>
        </span>
    </div>
    <?php endif?>
    
    <div class="col-md-8 col-md-offset-2" style="padding-top: 30px;">
    <?php if(AuthComponent::user('role') === 'admin'):?>
        <?php echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i> Editar este perfil', array('action'=>'edit_profile/'.$profile['DriverProfile']['driver_id']), array('escape'=>false))?>
    <?php endif?>
    </div>
</div>

<!-- TESTIMONIOS -->
<?php if(isset ($profile['Driver']['Testimonial']) && !empty ($profile['Driver']['Testimonial'])):?>

<div class="row">
    
    <div class="col-md-8 <?php if($userLoggedIn):?>col-md-offset-2<?php else:?>col-md-offset-1<?php endif?>">
        <hr/>
        <span class="lead">
            <?php echo __d('driver_profile', '%s tiene %s opiniones', Driver::shortenName($profile['DriverProfile']['driver_name']), count($profile['Driver']['Testimonial']))?>
        </span>
        <hr/>
    </div>
    
    <?php $i = 0?>
    <?php foreach ($profile['Driver']['Testimonial'] as $testimonial):?>
        <div class="col-md-8 col-md-offset-<?php if($userLoggedIn):?>2<?php else:?>1<?php endif?>">
            <?php echo $this->element('testimonial_body', array('testimonial'=>$testimonial));?>
            <br/>
            <br/>
        </div>
        <?php $i++?>
    <?php endforeach?>
    
</div>

<?php endif?>