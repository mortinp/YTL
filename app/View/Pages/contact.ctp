<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <big>
                <blockquote>
                    <?php
                    $imgBaseUrl = '/img';
                    if(Configure::read('debug') > 0) {
                        $imgBaseUrl = '/yotellevo'.$imgBaseUrl;
                    }
                    ?>
                    
                    <div><img src="<?php echo $imgBaseUrl.'/avatar-martin-bgdefault.jpg'?>"/></div>
                    <div class="text-muted">
                        
                        <?php echo __('Hola, mi nombre es %s.', 'Martín')?>
                        <?php echo __('¿Quieres preguntarme algo o simplemente decir <em>hola</em>? Escríbeme a mi correo %s y responderé cuanto antes.', '<span class="text-info">martin@'. Configure::read('domain_name').'</span>')?>
                        <?php echo __('También puedes conectar conmigo en Twitter: %s.', '<a href="https://twitter.com/martinproenza">@martinproenza</a>')?>
                       
                    </div>
                </blockquote>
            </big>
        </div>
    </div>
</div>