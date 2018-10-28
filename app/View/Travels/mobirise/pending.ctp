<section class="mbr-section content4 cid-r73XL8yTpN" id="content4-22">

    

    <div class="container">
        <div class="media-container-row">
            <div class="title col-12 col-md-8">
                <p class="align-left mbr-fonts-style display-5">
                    <?php echo __d('mobirise/pending_travel', 'Muchísimas gracias').'! '.__d('mobirise/pending_travel', 'Ya tenemos los datos de tu solicitud.')?>
                </p>
                <p class="mbr-section-subtitle align-left mbr-light mbr-fonts-style display-7">
                <?php echo __d('mobirise/pending_travel', 'Enseguida enviaremos tu solicitud a varios choferes acá en %s para que arregles precios y demás detalles del servicio con ellos.', 'Cuba')?>
                    <br><br><br>
                    <?php echo __d('mobirise/pending_travel', 'Como último paso <strong>crea una contraseña</strong> para que puedas gestionar tus conversaciones en el sitio y ver los perfiles de los choferes.', 'Cuba')?>
                </p>
                
            </div>
        </div>
        
        <br>
        <div class="media-container-row">
            <div class="col-12 col-md-8">
                <?php echo $this->Form->create('User', array('controller' => 'users', 'action' => 'register_and_create/'.$travel['PendingTravel']['id'])); ?>
                
                    <?php
                    echo $this->Form->input('username', array('label' => __d('mobirise/pending_travel', 'Tu correo electrónico'), 'value'=>$travel['PendingTravel']['email'], 'type' => 'hidden'));
                    echo $this->Form->input('lang', array('type' => 'hidden', 'value'=>  Configure::read('Config.language')));

                    echo '<div style="max-width:350px">'.$this->Form->input('password', array('label'=> '<b>'.__d('mobirise/pending_travel', 'Crea una contraseña para tu cuenta').'</b>', 'placeholder'=>__d('mobirise/pending_travel', 'Escribe la contraseña que usarás para YoTeLlevo'), 'autofocus')).'</div>';
                    ?>
                    <br>
                    <?php echo $this->element('mobirise/pending_travel')?>

                    <span class="input-group-btn">
                        <input type="submit" class="btn btn-primary btn-form display-5" value="<?php echo __d('mobirise/pending_travel', 'Enviar esta solicitud a los buzones de los choferes ahora')?>"> 
                    </span>
                    
                </form>
            </div>
        </div>
        
    </div>
</section>
<br><br><br>