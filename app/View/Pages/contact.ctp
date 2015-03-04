<div class="container">
    <div class="row">
        
        <div class="col-md-8 col-md-offset-2">
            <big>
                <blockquote>
                    <?php
                    $filesBaseUrl = '/files';
                    if(Configure::read('debug') > 0) {
                        $filesBaseUrl = '/yotellevo'.$filesBaseUrl;
                    }
                    ?>
                    
                    <div><img src="<?php echo $filesBaseUrl.'/1423878969_avatar-martin_jpg'?>"/></div>
                    <div class="text-muted">
                    <?php echo __('Hola, soy Martín.')?>
                        <?php echo __('¿Quieres preguntar algo o simplemente decir <em>hola</em>? Escríbeme a %s y responderé cuanto antes.', '<span class="text-info">martin@'. Configure::read('domain_name').'</span>')?>
                    </div>
                    
                </blockquote>
                
            </big>
        </div>
    </div>
</div>