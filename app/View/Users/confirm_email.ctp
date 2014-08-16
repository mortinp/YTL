<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h2><?php echo __('Tu cuenta de correo fue verificada exitosamente')?></h2>
            <h3>
                <?php echo __('Ahora puedes realizar todos los anuncios de viajes que desees, de forma <big>gratis</big>')?>.
            </h3>
            
            <br/>
            <div>
                <ul style="list-style-type: none; padding-left: 0px">
                <?php if($isLoggedIn): ?>
                   <li><?php echo $this->Html->link('<big>'.__('Ver todos mis Anuncios').'</big>', array('controller'=>'travels', 'action'=>'index'), array('escape'=>false));?></li>
                   <li><?php echo $this->Html->link(__('<big>'.__('Anunciar Viaje').'</big>'), array('controller' => 'travels', 'action' => 'add'), array('escape'=>false));?></li>
                <?php else: ?>
                    <li><big><?php echo $this->Html->link(__('Entra ahora'), array('controller' => 'users', 'action' => 'login'), array('escape'=>false));?> <?php echo __('para crear anuncios de viajes')?></big></li>
                <?php endif ?>
                </ul>
            </div>
        </div>
    </div>
</div>