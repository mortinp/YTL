<?php
$userEmail = $travel['User']['username'];
$emailDomain = substr($userEmail, strpos($userEmail, '@') + 1);
$emailHost = substr($emailDomain, 0, strpos($emailDomain, '.'));

$emailHostNiceName = ucfirst($emailHost);

$isBadEmailHost = in_array(strtolower($emailHost), array('hotmail', 'outlook', 'live'));
?>

<section class="header10 cid-rEvPPkCMBw mbr-parallax-background" id="header10-4f">
    <div class="container">
        <div class="media-container-column mbr-white p-5 align-left col-lg-8 col-md-10 m-auto">
            <h1 class="mbr-section-title mbr-bold pb-3 mbr-fonts-style display-5">
                <?php echo __d('mobirise/welcome', '¡Qué bueno tenerte a bordo!')?>
            </h1>
            
            <p class="mbr-text pb-3 mbr-fonts-style display-7">
                <?php echo __d('mobirise/welcome', 'Tu solicitud ya está en el inbox de varios de nuestros choferes. Comenzarás a recibir sus respuestas MUY PRONTO.')?>
            </p>
            <div class="mbr-section-btn">
                <?php echo $this->Html->link(__d('mobirise/welcome', 'Mira los detalles de tu solicitud').' &gt;&gt;', array('controller'=>'requests', 'action'=>'view', $travel['Travel']['id']), array('class'=>'btn btn-md btn-success display-4', 'escape'=>false))?>
            </div>
            <br>
            <?php if($isBadEmailHost):?>
            <div class="alert alert-danger">
                <p class="mbr-text pb-3 mbr-fonts-style display-7 text-white">
                    <i class="fa fa-warning"></i> <b><?php echo __d('mobirise/welcome', 'AVISO SOBRE %s', strtoupper($emailHost))?></b>:
                    <br>
                    <?php echo __d('mobirise/welcome', 'Hemos notado que <b>%s bloquea algunos de nuestros correos de notificaciones</b>.', $emailHostNiceName)?>
                    <?php echo __d('mobirise/welcome', 'Puede ser que no recibas las respuestas de los choferes en tu correo de %s.', $emailHostNiceName)?>                    
                    <br>
                    <?php echo __d('mobirise/welcome', 'Te recomendamos <b>usar otra dirección de correo (Gmail, Yahoo u otro)</b> para recibir las respuestas, o adiciona <em>yotellevocuba.com</em> a la lista de destinatarios seguros en tu cuenta de %s.', $emailHostNiceName)?>
                    
                    <br><br>
                    <?php echo $this->Html->link('<span class="mbri-setting3 mbr-iconfont mbr-iconfont-btn"></span>'.__d('mobirise/welcome', 'Configura otra dirección de correo en tu perfil'), array('controller'=>'users', 'action'=>'profile'), array('class'=>'btn btn-md btn-primary-outline display-3', 'target'=>'_blank', 'escape'=>false))?>
                    <!--<br><br>
                    * <?php echo __d('mobirise/welcome', 'Puedes cambiar tu dirección de correo en cualquier momento en los ajustes de tu perfil (menú arriba a la derecha)')?>-->
                </p>
            </div>
            <?php endif?>
        </div>
    </div>
</section>