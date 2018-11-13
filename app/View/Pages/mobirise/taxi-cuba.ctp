<section class="header9 cid-r6QOX37jx2 mbr-fullscreen" id="header9-7">
    <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(35, 35, 35);"></div>

    <div class="container">
        <div class="media-container-column mbr-white col-md-8">
            <h1 class="mbr-section-title align-left mbr-bold pb-3 mbr-fonts-style display-1">
                <br><?php echo __d('mobirise/taxi-cuba', 'Taxi en Cuba')?></h1>
            <h3 class="mbr-section-subtitle align-left mbr-light pb-3 mbr-fonts-style display-2">
                <span style="font-style: normal;">
                    <?php echo __d('mobirise/taxi-cuba', 'Averigua precios para taxi en Cuba directamente con el conductor que prestará el servicio')?>
                </span>
            </h3>
            <p class="mbr-text align-left pb-3 mbr-fonts-style display-5">
                <?php echo __d('mobirise/taxi-cuba', 'Accede a la mayor comunidad online de taxistas independientes en Cuba. Pregunta presupuesto para tus traslados y acuerda todo a partir de ahí.')?>
            </p>
            <div class="mbr-section-btn align-left">
                <a class="btn btn-md btn-primary display-5" href="#<?php echo __d('mobirise/default', 'solicitar')?>">
                    <span class="mbri-cust-feedback mbr-iconfont mbr-iconfont-btn"></span>
                    <?php echo __d('mobirise/taxi-cuba', 'Sí, solicitar precio a taxistas en Cuba')?>
                </a>
            </div>
        </div>
    </div>

    
</section>

<section class="features1 cid-r6QPNTAAQp" id="features1-9">
    <div class="container">
        <div class="media-container-row">

            <div class="card p-3 col-12 col-md-6 col-lg-4">
                <div class="card-img pb-3">
                    <span class="mbr-iconfont mbri-question"></span>
                </div>
                <div class="card-box">
                    <h4 class="card-title py-3 mbr-fonts-style display-5">
                        <?php echo __d('mobirise/taxi-cuba', 'Recibe múltiples ofertas')?></h4>
                    <p class="mbr-text mbr-fonts-style display-5">
                        <?php echo __d('mobirise/taxi-cuba', 'Te permitiremos intercambiar mensajes y <b>comunicarte directamente con varios choferes acá en Cuba</b> para que acuerdes todo con ellos. Recibe múltiples ofertas de precios.')?></p>
                </div>
            </div>

            <div class="card p-3 col-12 col-md-6 col-lg-4">
                <div class="card-img pb-3">
                    <span class="mbr-iconfont mbri-image-gallery"></span>
                </div>
                <div class="card-box">
                    <h4 class="card-title py-3 mbr-fonts-style display-5">
                        <?php echo __d('mobirise/taxi-cuba', 'Conoce a los choferes')?></h4>
                    <p class="mbr-text mbr-fonts-style display-5">
                        <?php echo __d('mobirise/taxi-cuba', '<b>Podrás ver fotos de los choferes y sus autos, así como opiniones de clientes anteriores</b> que han hecho viajes con ellos. Esto te ayudará a decidir cuál es mejor para tí.')?>
                    </p>
                </div>
            </div>

            <div class="card p-3 col-12 col-md-6 col-lg-4">
                <div class="card-img pb-3">
                    <span class="mbr-iconfont mbri-touch"></span>
                </div>
                <div class="card-box">
                    <h4 class="card-title py-3 mbr-fonts-style display-5">
                        <?php echo __d('mobirise/taxi-cuba', 'Contrata a tu conductor')?></h4>
                    <p class="mbr-text mbr-fonts-style display-5">
                        <?php echo __d('mobirise/taxi-cuba', '<b>Puedes contratar cualquier traslado si así lo deseas</b>: recogida en aeropuerto, taxi directo a un destino, taxi con chofer a tiempo completo por varios días, tours alrededor de la isla, etc.')?>
                    </p>
                </div>
            </div>

            

        </div>

    </div>

</section>

<section class="features16 cid-r6QXtixtYd" id="features16-c">
    
    <div class="container align-center">
        <h2 class="pb-3 mbr-fonts-style mbr-section-title display-2"><?php echo __d('mobirise/taxi-cuba', 'El servicio de taxi de nuestros choferes es usado todo el tiempo')?></h2>
        <h3 class="pb-5 mbr-section-subtitle mbr-fonts-style mbr-light display-5"><?php echo __d('mobirise/taxi-cuba', 'Mira opiniones e historias recientes de viajeros que han hecho recorridos y excursiones con taxistas de nuestra comunidad')?></h3>
        <div class="row media-row">
            

        <?php 

            $a = $testimonials_sample;
            /*$testimonials_sample = array(
                array('Testimonials'=>array('image_filepath'=>'files/1507920756_osvaldo-small_jpg', 'user_name'=>'Walter Camarda', 'driver_name'=>'Osvaldo', 'text'=>'We spend a full week around Cuba with Osvaldo in his historical car.Everything was amazing and he was for us not only a driver but a professional guide and like a friend. He gave us a lot of good suggestions for places to be seen and very successfully proposals for good and typical restaurants. We are very satisfied of our choice and surely we suggest to all the people will make a holiday trip in Cuba to get in touch with him to get an extremely reliable driver and guide. He is very kind, professional, friendly and always perfectly on time. His car is aesthetically very nice and original but more extremely conformable inside thanks to modern options he added like AC, electrical windows, automatic control gear, radio etc. Many thanks to OSVALDO !!!!!!!!!!!!!!!')),
                array('Testimonials'=>array('image_filepath'=>'files/1504788298_elmer-diego-netherlands-small_jpg', 'user_name'=>'Diego, Jasper, Martijn, Bas, Jorn', 'driver_name'=>'Elmer', 'text'=>'The best driver I ever experienced. Thankful, makes everything possible for his guests. I keep in contact with Elmer. Awesome guy!')),
                array('Testimonials'=>array('image_filepath'=>'files/1490801832_20170318_090341mb_jpg', 'user_name'=>'Penny and Dave', 'driver_name'=>'Erio', 'text'=>'We had a superb time in Cuba and our 9 days with Erio driving us in The Beast were great. He is a good driver and mechanic as well as being hardworking, warm and generous, there was nothing that was too much trouble. It always adds to a journey to travel with a good soul and that is how we felt with Erio. Many thanks, Penny and Dave')),
            );*/
        ?>
        <?php echo $this->element('mobirise/testimonials-summary', array('testimonial'=>$testimonials_sample[0]['Testimonial'], 'driver'=>$testimonials_sample[0]['Driver']))?>
        <?php echo $this->element('mobirise/testimonials-summary', array('testimonial'=>$testimonials_sample[1]['Testimonial'], 'driver'=>$testimonials_sample[1]['Driver']))?>
        <?php echo $this->element('mobirise/testimonials-summary', array('testimonial'=>$testimonials_sample[2]['Testimonial'], 'driver'=>$testimonials_sample[2]['Driver']))?>
            </div>    
    </div>
</section>

<section class="mbr-section info1 cid-r6R9vBujqk" id="info1-d">
    <div class="container">
        <div class="row justify-content-center content-row">
            <div class="media-container-column col-12 col-lg-6 col-md-6">
                <div class="mbr-section-btn py-4">
                    <?php echo $this->Html->link(__d('mobirise/taxi-cuba', 'Mira opiniones recientes sobre nuestros choferes'), array('controller'=>'testimonials', 'action'=>'featured', '?'=>array('also'=>Configure::read('Config.language') == 'es'?'en':'es')), array('class'=>'btn btn-success display-5'))?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mbr-section info2 cid-r6RhthSTKR" id="info2-e">
    <div class="container">
        <div class="row main justify-content-center">
            <div class="media-container-column title col-12 col-lg-7 col-md-6">
                <h2 class="align-left mbr-bold mbr-white pb-3 mbr-fonts-style display-2">
                    <?php echo __d('mobirise/taxi-cuba', 'Nuestra comunidad')?></h2>
                <h3 class="mbr-section-subtitle align-left mbr-light mbr-white mbr-fonts-style display-5"><b><?php echo __d('mobirise/taxi-cuba', 'Los conductores de taxi en Cuba son personas comunes que ponen sus autos a disposición de este servicio.')?></b></h3>
                <h3 class="mbr-section-subtitle align-left mbr-light mbr-white mbr-fonts-style display-5"><?php echo __d('mobirise/taxi-cuba', 'En nuestra plataforma incluímos pilotos retirados, pescadores, comediantes, contadores, médicos, todos propietarios de un auto y poseedores de licencia de taxi, que nos ayudan a moverte por la isla.')?></h3>
                <h3 class="mbr-section-subtitle align-left mbr-light mbr-white mbr-fonts-style display-5"><?php echo __d('mobirise/taxi-cuba', 'Conoce a algunos de ellos y llévate una primera impresión de la persona que estará al lado tuyo en tus recorridos por Cuba.')?></h3>
            </div>
            <div class="media-container-column col-12 col-lg-3 col-md-4">
                <div class="mbr-section-btn align-left py-4">
                    <a class="btn btn-primary display-4" href="#<?php echo __d('mobirise/default', 'solicitar')?>">
                    <span class="mbri-cust-feedback mbr-iconfont mbr-iconfont-btn"></span>
                    <?php echo __d('mobirise/taxi-cuba', 'Recibe ofertas de choferes en Cuba')?></a></div>
            </div>
        </div>
    </div>
</section>

<section class="mbr-section form1 cid-r6Ri3tnZFB" id="<?php echo __d('mobirise/default', 'solicitar')?>">
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="title col-12 col-lg-8">
                <h2 class="mbr-section-title align-center pb-3 mbr-fonts-style display-2"><?php echo __d('mobirise/taxi-cuba', 'Averigua precios de taxis en Cuba antes de contratar cualquier servicio')?></h2>
                <h3 class="mbr-section-subtitle align-center mbr-light pb-3 mbr-fonts-style display-5">
                <?php echo __d('mobirise/taxi-cuba', 'Comienza solicitando a varios choferes el precio para tus recorridos.')?>
                <br><?php echo __d('mobirise/taxi-cuba', 'Selecciona uno si así lo decides.')?></h3>
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
                    <?php echo __d('mobirise/taxi-cuba', 'Nuestra plataforma ha sido mencionada en los medios como uno de los negocios online líderes en Cuba')?></h3>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="carousel slide" data-ride="carousel" role="listbox" data-interval="false">
            <div class="carousel-inner" data-visible="5">
                
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
                </div><div class="carousel-item ">
                    <div class="media-container-row">
                        <div class="col-md-12">
                            <div class="wrap-img ">
                                <a href="https://oncubanews.com/cuba/economia/yo-te-llevo-una-startup-cubana-que-despega/" target="_blank"><img src="assets/images/oncuba-224x225.png" class="img-responsive clients-img" alt="" title=""></a>
                            </div>
                        </div>
                    </div>
                </div><div class="carousel-item ">
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