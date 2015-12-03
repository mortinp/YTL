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
                    <?php echo __('Hola, soy Martín.')?>
                        <?php echo __('¿Quieres preguntar algo o simplemente decir <em>hola</em>? Escríbeme a %s y responderé cuanto antes.', '<span class="text-info">martin@'. Configure::read('domain_name').'</span>')?>
                    </div>
                </blockquote>
            </big>
        </div>
    </div>
</div>