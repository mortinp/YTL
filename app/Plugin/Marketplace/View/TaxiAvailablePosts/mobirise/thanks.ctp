<section class="header10 cid-rEvPPkCMBw mbr-parallax-background" id="header10-4f">
    <div class="container">
        <div class="media-container-column mbr-white p-5 align-left col-lg-8 col-md-10 m-auto">
            <h1 class="mbr-section-title mbr-bold pb-3 mbr-fonts-style display-5">
                <?php echo __d('mobirise/welcome', '¡Muchas gracias por publicar la disponibilidad de tu taxi!')?>
            </h1>
            
            <p class="mbr-text pb-3 mbr-fonts-style display-7">
                <?php echo __d('mobirise/welcome', 'Ya la publicamos en nuestro sitio web y ya la pueden ver todos los que busquen taxi para esa fecha.')?>
                <br>
                <?php echo __d('mobirise/welcome', 'En los próximos minutos publicaremos también en otros lugares para que más personas puedan verla.')?>
            </p>
            <!--<div class="mbr-section-btn">
                <?php echo $this->Html->link(__d('mobirise/welcome', 'Mira los detalles de tu solicitud').' &gt;&gt;', array('controller'=>'requests', 'action'=>'view', $travel['Travel']['id']), array('class'=>'btn btn-md btn-success display-4', 'escape'=>false))?>
            </div>
            <br>-->
            <div class="alert alert-danger">
                <p class="mbr-text pb-3 mbr-fonts-style display-7 text-white">
                    <b><?php echo __d('mobirise/welcome', 'PUBLICA TU DISPONIBLIDAD PARA LOS PRÓXIMOS 7 DÍAS')?></b>:
                    <br><br>
                    <b><?php echo __d('mobirise/welcome', 'NO ESPERES AL DÍA ANTES PARA PUBLICAR. PUEDES HACERLO CON TIEMPO DE ANTELACIÓN Y ES MEJOR !')?></b>
                    <br><br>
                    <?php echo __d('mobirise/welcome', 'Te invitamos a que revises tu agenda de la próxima semana y publiques todos los retornos o viajes vacíos que tengas.')?>
                    <br>
                    <?php echo __d('mobirise/welcome', 'La mejor manera es publicar con tiempo de antelación para que los que buscan taxi tengan más tiempo de encontrate.')?>
                    
                    <br><br>
                    <?php echo $this->Html->link('<span class="fa fa-taxi"></span>&nbsp;'.__d('mobirise/welcome', 'PUBLICAR DISPONIBILIDAD PARA OTRO DÍA'), array('plugin'=>'marketplace', 'controller'=>'taxi_available_posts', 'action'=>'add_new_offer', '#'=>'publicar'), array('class'=>'btn btn-md btn-primary-outline display-3', 'escape'=>false))?>
                </p>
            </div>
        </div>
    </div>
</section>