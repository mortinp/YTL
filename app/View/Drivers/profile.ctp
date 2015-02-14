<div class="row">
    <div class="col-md-6 col-md-offset-3">Nuestros choferes son grandiosos, aquí te presentamos a <?php echo $profile['DriverProfile']['driver_name']?>:</div>
    <div id="content" class="col-md-12">
        <?php echo $profile['DriverProfile']['description']?>
    </div>
    
    <div class="col-md-6 col-md-offset-3" style="padding-top: 30px;">
    <?php if(AuthComponent::user('role') === 'admin'):?>
        <?php echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i> Editar este perfil', array('action'=>'edit_profile/'.$profile['DriverProfile']['driver_id']), array('escape'=>false))?>
    <?php endif?>
    </div>
</div>