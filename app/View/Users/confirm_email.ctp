<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <p class="lead"><?php echo __('Tu cuenta de correo fue verificada exitosamente')?></p>
            <br/>
            <br/>
            <?php echo $this->Html->link('<div class="btn btn-default"><big>&laquo;	'.__('Ver mis anuncios de viajes').'</big></div>', array('controller'=>'travels', 'action'=>'index'), array('escape'=>false))?>
        </div>
    </div>
</div>