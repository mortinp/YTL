<?php App::uses('Province', 'Model')?>
<div class="testimonials-item">
    <div class="user row">
        <div class="col-lg-3 col-md-4">
            <div class="user_image">
                <img src="<?php echo $driver['drivers_profiles']['featured_img_url']?>">
            </div>
        </div>
        <div class="testimonials-caption col-lg-3 col-md-4">
            <div class="user_text ">
                <p class="mbr-fonts-style  display-7">
                    <strong><?php echo $driver['drivers_profiles']['driver_name']?></strong>
                    <br><br>
                    <?php echo __d('mobirise/drivers_by_province', 'Vive en %s', Province::$provinces[$driver['drivers']['province_id']]['name'])?>
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
        
        <div class="col-lg-6 col-md-4" style="padding-top: 30px">
            <?php $hasFeaturedReview = $driver['latest_testimonial']['author'] != null;?>
            <?php if($hasFeaturedReview):?>
                <p class="text-muted"><span class="fa fa-comments-o"></span> <?php echo __($driver['latest_testimonial']['author']) ?>
                 <?php $hasCountry = $driver['latest_testimonial']['country'] != null;?>
                 <?php if($hasCountry):?> <?php echo __d('mobirise/testimonials', 'de %s', $driver['latest_testimonial']['country']) ?><?php endif; ?></p>
                <i>"<?php echo $this->Text->truncate($driver['latest_testimonial']['text'],250) ?>"</i>
            <?php endif; ?>
        </div>
    </div>
</div>