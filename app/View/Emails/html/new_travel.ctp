<p>Hola Chofer,</p>
<div>
    <p>
        Un nuevo anuncio de viaje (<b>#<?php echo $travel['Travel']['id']?></b>) ha sido registrado recientemente con los siguientes datos:
    </p>
    --------------------
    <p> 
        <?php echo $this->element('travel', array('travel'=>$travel, 'actions'=>false))?>
    </p>
    --------------------
    <p> 
        <?php $respondEmail = (Configure::read('conversations_via_app') && !isset ($admin));?>
        
        <?php if($respondEmail):?>
        Para comunicarte con el viajero <b>responde este correo SIN MODIFICAR EL ASUNTO</b>
        [<small><b>Nota:</b> Puedes responder desde otro correo, copiando el asunto de este correo en el que vayas a enviar</small>]
        <?php endif?>
        <?php if(!isset ($admin)):?>
        <div>¡Ponte en contacto <?php if(!Configure::read('conversations_via_app')):?>con el viajero<?php endif?> y haz que tu oferta sea la mejor!</div>
        <?php endif?>
    </p>
</div>

<?php 
if(!isset ($creator_role)) $creator_role = 'regular';
?>

<?php if(isset ($admin)):?>
    <small>
    <p>
        Usted recibió este correo porque es Administrador de <em>YoTeLlevo</em>.
    </p>
    <?php if(isset ($admin['drivers']) && count($admin['drivers']) > 0):?>
        <p>
            Se encontraron <?php echo count($admin['drivers'])?> choferes para notificar:
            <ul>
                <?php
                foreach ($admin['drivers'] as $d) {
                    echo '<li>'.$d['Driver']['username'].'</li>';
                }
                ?>
            </ul>
        </p>
        <p>
            <?php if($creator_role === 'regular'):?>
                Se notificaron exitosamente <b><?php echo $admin['notified_count']?></b> choferes.
            <?php else:?>
                Este viaje fue creado por un <b><?php echo $creator_role?></b>, por lo cual <b>fue enviado a choferes de prueba solamente</b>.
            <?php endif;?>
        </p>
    <?php endif?>
    </small>
<?php else: ?>
    <p>
        <small>
        Usted recibió este correo porque está registrado en <em>YoTeLlevo</em> como chofer que atiende viajes desde/hasta <?php echo $travel['Locality']['name']?>.
        </small>
    </p>
<?php endif?>