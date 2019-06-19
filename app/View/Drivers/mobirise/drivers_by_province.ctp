<?php App::uses('TimeUtil', 'Util')?>
<?php App::uses('Province', 'Model')?>

<section class="header1 cid-rss8alYxEU mbr-fullscreen" id="header16-3g">

    <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(35, 35, 35);">
    </div>

    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-10 align-center">
                <h1 class="mbr-section-title mbr-bold pb-3 mbr-fonts-style display-1"><?php echo __d('mobirise/drivers_by_province', 'Taxi & Chofer en %s', '<span style="display: inline-block">'.__($province['name']).'</span>')?></h1>
                <h2 class="mbr-text pb-3 mbr-fonts-style display-5"><?php echo Province::_servicesDescription($province['id'])?></h2>
                <p class="mbr-text pb-3 mbr-fonts-style display-5">
                    <br><strong><big><?php echo __d('mobirise/drivers_by_province', '%s choferes activos', count($drivers_data))?></big></strong>
                </p>
            </div>
        </div>
    </div>

</section>

<section class="testimonials4 cid-rsmhu3OqyL" id="testimonials4-3c">
    <div class="container">
        <div class="col-md-10 testimonials-container">
            
            <p class="mbr-text pb-3 mbr-fonts-style display-5">
                <i class="fa fa-check"></i> <?php echo __d('mobirise/homepage', 'Contacta a los choferes directamente')?>
                <br>
                <i class="fa fa-check"></i> <?php echo __d('mobirise/homepage', 'Averigua los precios para tus recorridos antes de llegar a la isla')?>
                <br>
                <i class="fa fa-check"></i> <?php echo __d('mobirise/homepage', 'Conoce a los choferes mientras intercambias correos')?>
                <br>
                <i class="fa fa-check"></i> <?php echo __d('mobirise/homepage', 'Mira fotos y opiniones de viajeros anteriores')?>
            </p>
            
            <p class="mbr-text pb-3 align-center mbr-fonts-style display-6">
                <?php echo __d('mobirise/drivers_by_province', 'Listando %s choferes que viven en %s, ordenados por fecha de última opinión recibida', count($drivers_data), __($province['name']))?>
            </p>

            <?php foreach($drivers_data as $driver):?>
                <?php echo $this->element('mobirise/driver_card', compact($driver))?>
            <?php endforeach?>
            
            <?php if(!empty($alternative_drivers_data)):?>
                <p class="mbr-text pb-3 align-center mbr-fonts-style display-6 mt-5">
                    <?php echo __d('mobirise/drivers_by_province', 'Oh oh, parece que %s choferes en %s no es mucho.', count($drivers_data), __($province['name']))?>
                    <br>
                    <strong><?php echo __d('mobirise/drivers_by_province', 'Aquí hay otros %s que viven en %s, cerca de %s', count($alternative_drivers_data), __(Province::$provinces[$province['alternative_province']]['name']), __($province['name']))?></strong>
                </p>
                
                <?php foreach($alternative_drivers_data as $driver):?>
                    <?php echo $this->element('mobirise/driver_card', compact($driver))?>
                <?php endforeach?>
            <?php endif?>

        </div>
    </div>
</section>

<!-- Poner el formulario de solicitud despues del nth testimonio -->
<section class="mbr-section form1 cid-r6Ri3tnZFB" id="<?php echo __d('mobirise/default', 'solicitar')?>">
    <div class="container">
        <div class="row justify-content-center">
            <div class="title col-12 col-lg-8">
                <h2 class="mbr-section-title align-center pb-3 mbr-fonts-style display-2"><?php echo __d('mobirise/testimonials', '¿Ya te gustan nuestros choferes?')?></h2>
                <h3 class="mbr-section-subtitle align-center mbr-light pb-3 mbr-fonts-style display-5">
                <?php echo __d('mobirise/testimonials', 'Solicita presupuesto para tu viaje a varios de ellos.')?>
                <br><?php echo __d('mobirise/homepage', 'Selecciona uno si así lo decides.')?></h3>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="media-container-column col-lg-8" data-form-type="formoid">
                <?php echo $this->element('mobirise/travel-form')?>
            </div>
        </div>
    </div>
</section>

<?php echo $this->element('mobirise/share-page')?>