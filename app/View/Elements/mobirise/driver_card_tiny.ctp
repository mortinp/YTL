<?php App::uses('Province', 'Model')?>
<div class="testimonials-item col-md-6 col-lg-4 col-sm-6 mt-5">
    <div style="background: #ffffff" class="pt-1 pb-3">
        <div class="col-lg-2 col-md-3">
            <div class="user_image" style="width: 150px;height: 150px;overflow: hidden;margin: 2rem auto 2rem auto;">
                <img src="<?php echo $driver['drivers_profiles']['featured_img_url']?>" style="width: 100%;min-width: 100%;min-height: 100%;">
            </div>
        </div>
        <div class="testimonials-caption col-lg-10 col-md-9">
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
                    

                    <br>
                    <?php echo __d('mobirise/drivers_by_province', '%s contratos', $driver[0]['travel_count'])?>, <?php echo __d('mobirise/drivers_by_province', '%s clientes', $driver[0]['total_travelers'])?><br>
                </p>
            </div>

            <div class="user_desk mbr-light mbr-fonts-style align-left pt-2 display-7">
                <?php echo $this->Html->link(__d('mobirise/drivers_by_province', 'Ver perfil'), array('controller'=>'drivers', 'action'=>'profile', $driver['drivers_profiles']['driver_nick']), array('class'=>'btn-sm btn-success'))?>
                <br> 
                <br>
                <?php if(isset($tour)): ?>
                  <a class="btn-sm btn-primary" data-toggle="modal" data-target="#contactModal<?php echo $driver['drivers_profiles']['driver_id']; ?>"><span class="fa fa- fa-send"></span> Contactar </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>