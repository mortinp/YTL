<p>Hola Chofer,</p>
<div>
    <p>
        Un nuevo anuncio de viaje ha sido registrado recientemente con los siguientes datos:
    </p>
    --------------------
    <p>
        <?php echo $this->element('travel_by_email', array('travel'=>$travel))?>
    </p>
    --------------------
    <p>
        <b>¡Ponte en contacto con el viajero y haz que tu oferta sea la mejor!</b>
    </p>
</div>

<?php 
if(!isset ($creator_role)) $creator_role = 'regular';
?>

<?php if(isset ($admin)):?>
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
<?php else: ?>
    <p>
        Usted recibió este correo porque está registrado en <em>YoTeLlevo</em>
        como chofer que atiende viajes desde/hasta <?php echo $travel['TravelByEmail']['matched']?>.
    </p>
<?php endif?>