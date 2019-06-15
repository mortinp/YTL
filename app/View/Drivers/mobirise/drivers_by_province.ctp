<?php App::uses('TimeUtil', 'Util')?>
<?php App::uses('Province', 'Model')?>

<section class="header1 cid-rss8alYxEU mbr-fullscreen" id="header16-3g">

    <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(35, 35, 35);">
    </div>

    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-10 align-center">
                <h1 class="mbr-section-title mbr-bold pb-3 mbr-fonts-style display-1"><?php echo __d('mobirise/drivers_by_province', 'Taxi & Chofer en %s', '<span style="display: inline-block">'.__($province['name']).'</span>')?></h1>

                <p class="mbr-text pb-3 mbr-fonts-style display-5">
                    <?php echo Province::_servicesDescription($province['id'])?>
                    <br><br>
                    <strong><big><?php echo __d('mobirise/drivers_by_province', '%s choferes activos', count($drivers_data))?></big></strong>
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
            <div class="testimonials-item">
                <div class="user row">
                    <div class="col-lg-3 col-md-4">
                        <div class="user_image">
                            <img src="<?php echo $driver['drivers_profiles']['featured_img_url']?>" alt="" title="">
                        </div>
                    </div>
                    <div class="testimonials-caption col-lg-9 col-md-8">
                        <div class="user_text ">
                            <p class="mbr-fonts-style  display-7">
                                <strong><?php echo $driver['drivers_profiles']['driver_name']?></strong>
                                <br><br>
                                <?php echo __d('mobirise/drivers_by_province', 'Vive en %s', $province['name'])?>
                                <br>
                                <?php echo __d('mobirise/drivers_by_province', 'Capacidad')?>: <strong><?php echo $driver['drivers']['max_people_count']?> pax</strong> 
                                
                                <?php if($driver['drivers']['has_air_conditioner']):?>
                                    <br>
                                    <b><?php echo __d('mobirise/drivers_by_province', 'Aire acondicionado')?></b>
                                <?php endif?>
                                
                                <br><br>
                                <?php $hasReview = $driver['testimonials']['review_count'] != null;?>
                                <?php if($hasReview):?>
                                    <?php echo __d('mobirise/drivers_by_province', '%s opiniones', $driver['testimonials']['review_count']);?>
                                    <small>
                                        <span class="text-muted">
                                            (<?php echo __d('mobirise/drivers_by_province', 'última el %s', TimeUtil::prettyDate($driver['testimonials']['latest_testimonial_date'], false));?>)
                                        </span>
                                    </small>
                                <?php else:?>
                                    <span class="text-danger"><?php echo __d('mobirise/drivers_by_province', 'No tiene opiniones');?></span>
                                <?php endif?>
                                
                                <br>
                                <?php echo __d('mobirise/drivers_by_province', '%s contratos', $driver[0]['travel_count'])?>, <?php echo __d('mobirise/drivers_by_province', '%s clientes', $driver[0]['total_travelers'])?><br>
                            </p>
                        </div>

                        <div class="user_desk mbr-light mbr-fonts-style align-left pt-2 display-7">
                            <?php echo $this->Html->link(__d('mobirise/drivers_by_province', 'Ver perfil'), array('controller'=>'drivers', 'action'=>'profile', $driver['drivers_profiles']['driver_nick']), array('class'=>'btn-sm btn-success'))?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach?>

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