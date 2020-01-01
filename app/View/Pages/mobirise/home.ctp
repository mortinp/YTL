<section class="header9 cid-r6QOX37jx2 mbr-fullscreen" id="header9-7">
    <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(35, 35, 35);"></div>

    <div class="container">
        <div class="media-container-column mbr-white col-md-8">
            <h1 class="mbr-section-title align-left mbr-bold pb-3 mbr-fonts-style display-2">
                <br><?php echo __d('mobirise/homepage', 'La mayor comunidad de choferes de taxi en Cuba')?>
            </h1>
            <h3 class="mbr-section-title align-left mbr-light pb-3 mbr-fonts-style display-5"><?php echo __d('mobirise/homepage', 'Listos para darte precios para tus traslados y para ser contratados')?></h3>
            <p class="mbr-text align-left pb-3 mbr-fonts-style display-5">
                <i class="fa fa-check"></i> <?php echo __d('mobirise/homepage', 'Contacta a los choferes directamente')?>
                <br>
                <i class="fa fa-check"></i> <?php echo __d('mobirise/homepage', 'Averigua precios de tus traslados antes de llegar a la isla')?>
                <br>
                <i class="fa fa-check"></i> <?php echo __d('mobirise/homepage', 'Conoce a los choferes mientras intercambias mensajes')?>
                <br>
                <i class="fa fa-check"></i> <?php echo __d('mobirise/homepage', 'Mira fotos y opiniones de viajeros anteriores')?>
            </p>
            <div class="mbr-section-btn align-left">
                <a class="btn btn-md btn-secondary display-5" href="#<?php echo __d('mobirise/default', 'solicitar')?>">
                    <span class="mbri-cust-feedback mbr-iconfont mbr-iconfont-btn"></span>
                    <?php echo __d('mobirise/homepage', 'Solicitar ofertas a choferes en Cuba')?>
                </a>
            </div>
        </div>
    </div>    
</section>

<section class="features1 cid-r6QPNTAAQp bg-white" id="features1-9">    
    <div class="container">
        <div class="media-container-row">

            <div class="card p-3 col-12 col-md-6 col-lg-4">
                <div class="card-img pb-3">
                    <span class="mbr-iconfont mbri-image-gallery" style="font-size: 60px"></span>
                </div>
                <div class="card-box">
                    <h4 class="card-title py-3 mbr-fonts-style display-5">
                        <?php echo __d('mobirise/homepage', 'Múltiples contactos')?></h4>
                    <p class="mbr-text mbr-fonts-style display-7">
                        <?php echo __d('mobirise/homepage', '<strong>Te ponemos en contacto directo con varios choferes en Cuba</strong> para que acuerdes tu viaje directamente con ellos via correo electrónico antes de llegar a la isla.')?></p>
                </div>
            </div>

            <div class="card p-3 col-12 col-md-6 col-lg-4">
                <div class="card-img pb-3">
                    <span class="mbr-iconfont mbri-question" style="font-size: 60px"></span>
                </div>
                <div class="card-box">
                    <h4 class="card-title py-3 mbr-fonts-style display-5">
                        <?php echo __d('mobirise/homepage', 'Averigua los precios')?></h4>
                    <p class="mbr-text mbr-fonts-style display-7">
                        <?php echo __d('mobirise/homepage', '<strong>Los choferes te darán sus precios</strong> y tú puedes preguntar cualquier cosa relativa al viaje. Conoce un poco a los choferes mientras intercambian correos y ves sus fotos.')?>
                    </p>
                </div>
            </div>

            <div class="card p-3 col-12 col-md-6 col-lg-4">
                <div class="card-img pb-3">
                    <span class="mbr-iconfont mbri-touch" style="font-size: 60px"></span>
                </div>
                <div class="card-box">
                    <h4 class="card-title py-3 mbr-fonts-style display-5">
                        <?php echo __d('mobirise/homepage', 'Encuentra a tu chofer')?></h4>
                    <p class="mbr-text mbr-fonts-style display-7">
                        <?php echo __d('mobirise/homepage', '<strong>Contrata al chofer que creas mejor</strong> de acuerdo a tu presupuesto, necesidades especiales o porque te gusta su auto. Haz un amigo que te lleve a donde quieras ir.')?>
                    </p>
                </div>
            </div>

        </div>
    </div>

</section>

<section class="features16 cid-r6QXtixtYd" id="features16-c">
    <div class="container align-center">
        <h2 class="pb-3 mbr-fonts-style mbr-section-title display-5"><?php echo __d('mobirise/homepage', '%s recomendaciones de viajeros como tú', $stats['reviews'])?></h2>
        <h3 class="pb-5 mbr-section-subtitle mbr-fonts-style mbr-light display-5"><?php echo __d('mobirise/homepage', 'Míralas en los perfiles de los choferes y decide si quieres contratar a alguno')?></h3>
        <div class="row media-row">
        <?php echo $this->element('mobirise/testimonials-summary', array('testimonial'=>$testimonials_sample[0]['Testimonial'], 'driver'=>$testimonials_sample[0]['Driver']))?>
        <?php echo $this->element('mobirise/testimonials-summary', array('testimonial'=>$testimonials_sample[1]['Testimonial'], 'driver'=>$testimonials_sample[1]['Driver']))?>
        <?php echo $this->element('mobirise/testimonials-summary', array('testimonial'=>$testimonials_sample[2]['Testimonial'], 'driver'=>$testimonials_sample[2]['Driver']))?>
        </div>    
    </div>
    <div class="container">
        <div class="row justify-content-center content-row">
            <div class="media-container-column col-12 col-lg-6 col-md-6">
                <div class="mbr-section-btn py-4">
                    <?php echo $this->Html->link(__d('mobirise/homepage', 'Mira opiniones recientes sobre nuestros choferes'), array('controller'=>'testimonials', 'action'=>'featured', '?'=>array('also'=>Configure::read('Config.language') == 'es'?'en':'es')), array('class'=>'btn btn-success-outline display-3'))?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mbr-section article content9 cid-r6T2jWJ6t5" id="content9-m">
    <div class="container">
        <div class="inner-container" style="width: 100%;">
            <hr class="line" style="width: 25%;">
            <div class="section-text align-center mbr-fonts-style display-5">
                <strong><?php echo __d('mobirise/homepage', 'Taxi para todo tipo de servicios')?></strong>
                <br>
                <?php echo __d('mobirise/homepage', 'Recogida en aeropuerto, llegar directo a un destino, chofer a tiempo completo por varios días, tours alrededor de la isla... de todo')?>
                <br>
                <br>
                <strong><?php echo __d('mobirise/homepage', 'Desde y hasta cualquier lugar')?></strong>
                <br>
                <?php echo __d('mobirise/homepage', '%s y más.', 'La Habana, Viñales, Trinidad, Varadero, Cienfuegos, Santa Clara, Cayo Guillermo, Holguín, Santiago de Cuba')?></div>
            <hr class="line" style="width: 25%;">
        </div>
        </div>
</section>

<section class="mbr-section info3 cid-rCJesiT9iX mbr-parallax-background" id="info3-3z">
    <div class="mbr-overlay" style="opacity: 0.5; background-color: rgb(35, 35, 35);"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="media-container-column title col-12 col-md-10">
                <h2 class="align-left mbr-bold mbr-white pb-3 mbr-fonts-style display-2"><?php echo __d('mobirise/taxi-prices-cuba', 'El chofer con quien viajas es importante y hace la diferencia')?></h2>
                <h3 class="mbr-section-subtitle align-left mbr-light mbr-white pb-3 mbr-fonts-style display-5"><?php echo __d('mobirise/taxi-prices-cuba', 'Nuestros choferes son <strong>pilotos retirados</strong>, <strong>pescadores</strong>, <strong>comediantes</strong>, <strong>contadores</strong>, <strong>músicos</strong>, todos <strong>propietarios de un auto que nos ayudan a moverte por la isla</strong>. Conecta con tu chofer de la manera que prefieras.')?></h3>
                
                <div class="mbr-section-btn align-left py-4">
                    <a class="btn btn-secondary display-4" href="#<?php echo __d('mobirise/default', 'solicitar')?>">
                    <span class="mbri-cust-feedback mbr-iconfont mbr-iconfont-btn"></span>
                    <?php echo __d('mobirise/taxi-prices-cuba', 'Solicita presupuesto ahora')?></a></div>
            </div>
        </div>
    </div>
</section>

<section class="mbr-section form1 cid-r6Ri3tnZFB" id="<?php echo __d('mobirise/default', 'solicitar')?>">
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="title col-12 col-lg-8">
                <h2 class="mbr-section-title align-center pb-3 mbr-fonts-style display-2"><?php echo __d('mobirise/homepage', 'Haz un viaje sorprendente con tu chofer en Cuba')?></h2>
                <h3 class="mbr-section-subtitle align-center mbr-light pb-3 mbr-fonts-style display-5">
                <?php echo __d('mobirise/homepage', 'Comienza solicitando a varios choferes el precio para tus recorridos.')?>
                <br><?php echo __d('mobirise/homepage', 'Explícales la idea de lo que quieres hacer')?></h3>
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

<section class="clients cid-r78OCrmB2F" id="clients-23">
    <div class="container mb-5">
        <div class="media-container-row">
            <div class="col-12 align-center">

                <h3 class="mbr-section-subtitle mbr-light mbr-fonts-style display-5">
                    <?php echo __d('mobirise/homepage', 'Nuestra plataforma ha sido mencionada en los medios como uno de los negocios online líderes en Cuba')?></h3>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="carousel slide" data-ride="carousel" role="listbox" data-interval="false">
            <div class="carousel-inner" data-visible="6">
                
            <div class="carousel-item ">
                    <div class="media-container-row">
                        <div class="col-md-12">
                            <div class="wrap-img ">
                                <a href="https://huffingtonpost.com/scott-norvell/an-uber-for-cuba_b_6987824.html" target="_blank"><img src="assets/images/huffpost-logo-240x240.png" class="img-responsive clients-img" alt="" title=""></a>
                            </div>
                        </div>
                    </div>
                </div><div class="carousel-item ">
                    <div class="media-container-row">
                        <div class="col-md-12">
                            <div class="wrap-img ">
                                <a href="https://techcrunch.com/2015/10/06/cubas-startup-paradox/" target="_blank"><img src="assets/images/techcrunch-602x302.png" class="img-responsive clients-img" alt="" title=""></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item ">
                    <div class="media-container-row">
                        <div class="col-md-12">
                            <div class="wrap-img ">
                                <a href="https://whynotcuba.com/taxi-cuba/" target="_blank"><img src="assets/images/whynotcuba-logo.png" class="img-responsive clients-img" alt="" title=""></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item ">
                    <div class="media-container-row">
                        <div class="col-md-12">
                            <div class="wrap-img ">
                                <a href="https://oncubanews.com/cuba/economia/yo-te-llevo-una-startup-cubana-que-despega/" target="_blank"><img src="assets/images/oncuba-224x225.png" class="img-responsive clients-img" alt="" title=""></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item ">
                    <div class="media-container-row">
                        <div class="col-md-12">
                            <div class="wrap-img ">
                                <a href="https://www.eldiario.es/hojaderouter/internet/Cuba-revolucion_digital-tecnologia-internet-bloqueo_0_647435540.html" target="_blank"><img src="assets/images/eldiario.es-543x93.png" class="img-responsive clients-img" alt="" title=""></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item ">
                    <div class="media-container-row">
                        <div class="col-md-12">
                            <div class="wrap-img ">
                                <a href="https://www.elconfidencial.com/tecnologia/2015-11-21/frente-al-aislamiento-creatividad-los-pioneros-de-las-startups-en-cuba_1102913/" target="_blank"><img src="assets/images/el-confidencial-610x406.png" class="img-responsive clients-img" alt="" title=""></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-controls d-lg-none" aria-hidden="true">
                <a data-app-prevent-settings="" class="carousel-control carousel-control-prev" role="button" data-slide="prev">
                    <span aria-hidden="true" class="mbri-left mbr-iconfont"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a data-app-prevent-settings="" class="carousel-control carousel-control-next" role="button" data-slide="next">
                    <span aria-hidden="true" class="mbri-right mbr-iconfont"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
</section>

<?php echo $this->element('mobirise/share-page')?>