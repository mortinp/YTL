<?php App::uses('DriverProfile', 'Model')?>

<?php 
$driver_name = $profile['DriverProfile']['driver_name'];
$driver_short_name = Driver::shortenName($driver_name);
$driverIsActive = $profile['Driver']['active'];
?>

<!-- TESTIMONIOS -->
<?php
$testimonialsCount = $this->request->paging['Testimonial']['count'];
$hasTestimonials = $testimonials != null && count($testimonials) > 0;
?>

<?php $talkingToDriver = $this->Session->read('visited-driver-'.$profile['Driver']['id']);?>

<section class="header3 cid-r6WgrSBMcu" id="header3-10">

    <div class="container">
        <div class="media-container-row">
            <div class="mbr-figure" style="width: 50%;">
                <img src="<?php echo $profile['DriverProfile']['featured_img_url']?>" alt="<?php echo $driver_short_name?>" title="">
            </div>

            <div class="media-content">
                <h1 class="mbr-section-title mbr-white pb-3 mbr-fonts-style display-2">
                    <?php echo __d('mobirise/driver_profile', 'Conoce a %s', $driver_name)?></h1>
                
                <div class="mbr-section-text mbr-white pb-3 ">
                    <p class="mbr-text mbr-fonts-style display-5">
                        <?php echo __d('mobirise/driver_profile', 'Chofer de taxi en %s', $profile['Province']['name'])?>, Cuba</p>
                </div>
                <div class="mbr-section-btn">
                    <?php if($talkingToDriver):?>
                        <?php echo $this->Html->link('<span class="mbri-cust-feedback mbr-iconfont mbr-iconfont-btn"></span> '.__d('mobirise/driver_profile', 'Ver mis mensajes con %s', $driver_short_name), array('controller'=>'conversations', 'action'=>'messages', $talkingToDriver), array('escape'=>false, 'class'=>'btn btn-md btn-primary display-4'))?>
                    <?php else:?>
                        <a class="btn btn-md btn-primary display-4" href="#<?php echo __d('mobirise/default', 'solicitar')?>">
                            <span class="mbri-cust-feedback mbr-iconfont mbr-iconfont-btn"></span>
                            <?php echo __d('mobirise/driver_profile', 'Recibir oferta de %s', $driver_short_name)?>
                        </a>
                    <?php endif?>
                    
                    <?php echo $this->Html->link(__d('mobirise/driver_profile', 'Opinar sobre %s', $driver_short_name), array('controller' => 'testimonials', 'action'=>'enter_code'), array('escape'=>false, 'class'=>'btn btn-md btn-white-outline display-4'))?>
                </div>
            </div>
        </div>
    </div>

</section>

<section class="features1 cid-r6WltItbex" id="features1-14">
    
    <div class="container">
        <div class="media-container-row">

            <div class="card p-3 col-12 col-md-6 col-lg-4">
                <div class="card-img pb-3">
                    <span class="mbr-iconfont mbri-pin"></span>
                </div>
                <div class="card-box">
                    <h4 class="card-title py-3 mbr-fonts-style display-5"><?php echo __d('mobirise/driver_profile', 'Vive en %s', $profile['Province']['name'])?></h4>
                    
                </div>
            </div>

            <div class="card p-3 col-12 col-md-6 col-lg-4">
                <div class="card-img pb-3">
                    <span class="mbr-iconfont mbri-delivery"></span>
                </div>
                <div class="card-box">
                    <h4 class="card-title py-3 mbr-fonts-style display-5">
                        <?php echo __d('mobirise/driver_profile', 'Auto hasta %s pax', $profile['Driver']['max_people_count'])?>
                        <?php if($profile['Driver']['has_air_conditioner']) echo '<br>'.__d('mobirise/driver_profile', 'Aire acondicionado')?>
                    </h4>
                </div>
            </div>

            <div class="card p-3 col-12 col-md-6 col-lg-4">
                <div class="card-img pb-3">
                    <span class="mbr-iconfont mbri-like"></span>
                </div>
                <div class="card-box">
                    <h4 class="card-title py-3 mbr-fonts-style display-5"><?php echo __d('mobirise/driver_profile', '%s opiniones', $testimonialsCount)?></h4>
                </div>
            </div>

            

        </div>

    </div>

</section>

<?php $desc = json_decode($profile['DriverProfile']['description_'.Configure::read('Config.language')], true)?>
<?php if($desc != null):?>
<section class="mbr-gallery mbr-slider-carousel cid-r6WhQMK4gz" id="gallery1-11">
    <div class="container">
        <div><!-- Filter --><!-- Gallery -->
            <div class="mbr-gallery-row">
                <div class="mbr-gallery-layout-default">
                    <div>
                        <div>
                            <?php $i = 0?>
                            <?php foreach ($desc['pics'] as $pic):?>
                                <?php
                                $attr = '';
                                foreach ($pic as $prop=>$val) {
                                    $attr .= $prop.'="'.$val.'" ';
                                }
                                ?>
                                <div class="mbr-gallery-item mbr-gallery-item--p1" data-video-url="false" data-tags="Responsive">
                                    <div href="#lb-gallery1-11" data-slide-to="<?php echo $i?>" data-toggle="modal">
                                        <img <?php echo $attr?> >
                                        <span class="icon-focus"></span>
                                    </div>
                                </div>
                                <?php $i++?>
                            <?php endforeach?>
                            
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    
                </div>
                
            </div><!-- Lightbox -->
            <div data-app-prevent-settings="" class="mbr-slider modal fade carousel slide" tabindex="-1" data-keyboard="true" data-interval="false" id="lb-gallery1-11">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="carousel-inner">
                                <?php $i = 0?>
                                <?php foreach ($desc['pics'] as $pic):?>
                                    <?php
                                    $attr = '';
                                    foreach ($pic as $prop=>$val) {
                                        $attr .= $prop.'="'.$val.'" ';
                                    }
                                    ?>
                                    <div class="carousel-item <?php if($i == 0) echo 'active'?>">
                                        <img <?php echo $attr?> >
                                    </div>
                                    <?php $i++?>
                                <?php endforeach?>
                            </div>
                            <a class="carousel-control carousel-control-prev" role="button" data-slide="prev" href="#lb-gallery1-11">
                                <span class="mbri-left mbr-iconfont" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control carousel-control-next" role="button" data-slide="next" href="#lb-gallery1-11">
                                <span class="mbri-right mbr-iconfont" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                            <a class="close" href="#" role="button" data-dismiss="modal">
                                <span class="sr-only">Close</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<?php else:?>
<section class="features1 cid-r6WltItbex">
    <div class="container">
        <div class="media-container-row">
            <?php echo $profile['DriverProfile']['description_'.Configure::read('Config.language')]?>
        </div>
    </div>
</section>
<?php endif?>


<?php echo $this->element('mobirise/ajax_testimonials_list', compact('testimonials')); ?>

<?php if(!$talkingToDriver):?>
    
    <?php if(!$driverIsActive):?>
        <section class="mbr-section info1 cid-r6R9vBujqk" id="<?php echo __d('mobirise/default', 'solicitar')?>" style="padding-top: 30px">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="alert alert-danger">
                        <?php echo __d('mobirise/driver_profile', 'Este chofer no puede ser contactado pues no está activo en nuestra plataforma actualmente')?>
                    </div>
                </div>
            </div>
        </section>
    <?php else:?>
        <?php
        $formSectionTitle = __d('mobirise/driver_profile', '¿Te interesa contratar un chofer privado en Cuba?');
        $formSectionSubtitle = __d('mobirise/driver_profile', '<strong>Contacta a %s</strong> y recibe una oferta directamente de él para el viaje que quieres hacer', $driver_short_name);

        $isShowingDiscount = $this->request->query('discount') && $discount != null;

        if($isShowingDiscount) {
            $formSectionTitle = __d('mobirise/cheap_taxi', '%s ofrece:<br>Taxi privado <span style="display:inline-block">%s > %s</span><br>%s', 
                    $driver_name, 
                    '<strong>'.$discount['DiscountRide']['origin'].'</strong>',
                    '<strong>'.$discount['DiscountRide']['destination'].'</strong>',
                    '<strong>'.$discount['DiscountRide']['price'].' cuc'.'</strong>');
            $formSectionSubtitle = __d('mobirise/cheap_taxi', '<strong>Contacta a %s</strong> y reserva este viaje para el próximo %s', 
                    $driver_short_name,
                    '<span style="display:inline-block"><strong>'.TimeUtil::prettyDate($discount['DiscountRide']['date'],false).'</strong></span>');
        }
        ?>
        <section class="mbr-section form1 cid-r6WrVSFSDf" id="<?php echo __d('mobirise/default', 'solicitar')?>">
            
            <div class="container">
                <div class="row justify-content-center content-row">
                    <div class="title col-12 col-lg-8">
                        <h2 class="mbr-section-title align-center pb-3 mbr-fonts-style display-5">
                            <?php echo $formSectionTitle?></h2>
                        <h3 class="mbr-section-subtitle align-center mbr-light pb-3 mbr-fonts-style display-5">
                            <?php echo $formSectionSubtitle?></h3>
                    </div>
                </div>
            </div>
            
            <div class="container">
                
                <?php if($isShowingDiscount): ?>
                    <?php $pickerdate = TimeUtil::dateFormatForPicker($discount['DiscountRide']['date']); echo "<script type='text/javascript'>var pickervalue='".$pickerdate."'; </script>"; ?>
                    <div class="row cid-rDj8V5iu3T justify-content-center" style="background-color: white;padding:0px">
                        <div class="plan col-md-4 justify-content-center favorite">
                            <?php echo $this->element('mobirise/discounts/offer_info', compact('discount') + array('showButton'=>false))?>
                        </div>

                        <div class="col-12 d-md-none" style="height:50px"></div>
                        <div class="col-md-7 offset-md-1" id="<?php echo $discount['DiscountRide']['id']; ?>" data-form-type="formoid">
                            <?php echo $this->element('mobirise/form_write_to_driver', array('discount_id'=>$discount['DiscountRide']['id']))?>
                        </div>
                    </div>
                   <?php else: ?>
                   <?php if($profile['Driver']['for_tours']==1): ?>
                     <div class="row justify-content-center">
                        <div class="media-container-column col-lg-8" data-form-type="formoid">
                            <?php echo $this->element('mobirise/form_write_to_driver',array('tour'=>true))?>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="row justify-content-center">
                        <div class="media-container-column col-lg-8" data-form-type="formoid">
                            <?php echo $this->element('mobirise/form_write_to_driver')?>
                        </div>
                    </div>
                   <?php endif; ?>  
                <?php endif; ?>

            </div>
            
        </section>
    <?php endif; ?>
<?php else:?>
    <section class="mbr-section info1 cid-r6R9vBujqk" id="<?php echo __d('mobirise/default', 'solicitar')?>" sstyle="padding-top: 100px">
        <div class="container">
            <hr class="line" style="width: 25%;">
            <div class="row justify-content-center content-row">
                <div class="media-container-column title col-12 col-lg-7 col-md-6">
                    <p class="mbr-section-subtitle align-left mbr-light pb-3 mbr-fonts-style display-5">
                        <?php echo __d('mobirise/driver_profile', 'Ya tienes una conversación con %s', $driver_short_name)?>
                    </p>
                </div>
                <div class="media-container-column col-12 col-lg-3 col-md-4">
                    <div class="mbr-section-btn align-right py-4">
                        <?php echo $this->Html->link('<span class="mbri-cust-feedback mbr-iconfont mbr-iconfont-btn"></span> '.__d('mobirise/driver_profile', 'Ver mis mensajes con %s', $driver_short_name), array('controller'=>'conversations', 'action'=>'messages', $talkingToDriver), array('escape'=>false, 'class'=>'btn btn-sm btn-primary display-4'))?>
                    </div>
                </div>
            </div>
            <hr class="line" style="width: 25%;">
        </div>
    </section>
<?php endif?>

<?php if(count($other_drivers['drivers_data'])>0): ?>
<section class="testimonials4 cid-rsmhu3OqyL">
    <div class="container">
        <h3 class="mbr-section-subtitle align-center mbr-light pb-3 mbr-fonts-style display-5">
            <?php echo __d('mobirise/driver_profile', 'Mira otros choferes de taxi en %s', __($profile['Province']['name']))?>
        </h3> 
        <div class="row content-row">                    
            <?php foreach($other_drivers as $odriver):?>
                <?php foreach($odriver as $driver):?>                             
                    <?php echo $this->element('mobirise/driver_card_tiny', compact($driver))?>
                <?php endforeach?> 
            <?php endforeach?>
        </div>
    </div>
</section>
<?php endif;?>

<?php echo $this->element('mobirise/share-page')?>