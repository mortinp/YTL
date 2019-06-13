<?php App::uses('TimeUtil', 'Util')?>

<section class="header1 cid-rss8alYxEU mbr-fullscreen" id="header16-3g">

    <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(35, 35, 35);">
    </div>

    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-10 align-center">
                <h1 class="mbr-section-title mbr-bold pb-3 mbr-fonts-style display-1"><?php echo __d('mobirise/drivers_by_province', 'Taxi & Chofer en %s', '<span style="display: inline-block">'.__($province['name']).'</span>')?></h1>

                <p class="mbr-text pb-3 mbr-fonts-style display-5">Taxi a tiempo completo - Recogida en aeropuerto de La Habana - Tour por toda Cuba - Tour de un día a Viñales - Traslados desde La Habana a cualquier destino
                    <br><br>
                    <strong><big><?php echo __d('mobirise/drivers_by_province', '%s choferes activos', count($drivers_data))?></big></strong>
                </p>
            </div>
        </div>
    </div>

</section>

<section class="testimonials4 cid-rsmhu3OqyL" id="testimonials4-3c">

    <div class="container">

        <h3 class="mbr-section-subtitle mbr-light pb-3 mbr-fonts-style mbr-white align-center display-5">Estos choferes están disponibles para contratarlos para tus recorridos en Cuba comenzando en La Habana. <strong>Puedes preguntarles directamente por precios desde sus perfiles.</strong><br>
        </h3>
        <div class="col-md-10 testimonials-container">

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
                                Capacidad: <strong><?php echo $driver['drivers']['max_people_count']?> pax</strong> 
                                
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
                            <?php echo $this->Html->link('Ver perfil', array('controller'=>'drivers', 'action'=>'profile', $driver['drivers_profiles']['driver_nick']), array('class'=>'btn-sm btn-success'))?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach?>

        </div>
    </div>
</section>

<?php echo $this->element('mobirise/share-page')?>