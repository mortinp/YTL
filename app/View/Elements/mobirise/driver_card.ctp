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