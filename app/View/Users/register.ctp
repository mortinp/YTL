<div class="container">
<div class="row">
    <div class="col-md-6 col-md-offset-2">
        <?php echo $this->Session->flash('auth'); ?>
        <div class="text-muted">
            <b><?php echo __('¿Ya tienes una cuenta?')?></b> 
            <?php echo $this->Html->link(__('Entra y gestiona tus viajes'), array('controller'=>'users', 'action'=>'login'), array('escape'=>false))?>
        </div>
        <br/>
        <legend><?php echo __('Regístrate y consigue un taxi para tu viaje'); ?></legend>
        <?php echo $this->element('register_form') ?>
    </div>
</div>
</div>