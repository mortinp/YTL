<section class="header1 cid-rCIPKaPIfg mbr-parallax-background" id="header1-3v">

    <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(35, 35, 35);">
    </div>

    <div class="container">
        <div class="row justify-content-md-center">
            <div class="mbr-white col-md-10">
                <h1 class="mbr-section-title align-center mbr-bold pb-3 mbr-fonts-style display-5">
                    <br><?php echo __d('mobirise/taxi-prices-cuba', '¿Buscas opciones de traslados en Cuba?')?></h1>
                <h3 class="mbr-section-subtitle align-center mbr-light pb-3 mbr-fonts-style display-2"><strong>
                    <?php echo __d('mobirise/taxi-prices-cuba', 'Comienza tu búsqueda de mejores precios de taxi privado en Cuba aquí')?></strong></h3>
                <p class="mbr-text align-center pb-3 mbr-fonts-style display-5"><?php echo __d('mobirise/taxi-prices-cuba', 'Conoce los precios directamente de conductores activos en el negocio de taxi para turismo en la isla')?></p>
                <div class="mbr-section-btn align-center">
                    <a class="btn btn-md btn-secondary display-4" href="#<?php echo __d('mobirise/default', 'solicitar')?>">
                        <span class="mbri-cust-feedback mbr-iconfont mbr-iconfont-btn"></span>
                        <?php echo __d('mobirise/taxi-prices-cuba', 'Recibe ofertas de 5 choferes en menos de 12 horas')?>
                    </a>
                </div>
            </div>
        </div>
    </div>

</section>

<section class="features4 cid-rCIRD11RkG" id="features4-3w">
    
    <div class="container">
        <div class="media-container-row">
            <div class="card p-3 col-12 col-md-6 col-lg-4">
                <div class="card-wrapper media-container-row media-container-row">
                    <div class="card-box">
                        <h4 class="card-title pb-3 mbr-fonts-style display-5">
                            <?php echo __d('mobirise/taxi-prices-cuba', 'Fácil')?></h4>
                        <p class="mbr-text mbr-fonts-style display-7">
                            <?php echo __d('mobirise/taxi-prices-cuba', 'Simplemente <strong>envía tu idea</strong> de los recorridos que deseas realizar, y <strong>te conectaremos con múltiples conductores</strong> independientes acá en la isla y sus ofertas llegarán a tu inbox.')?></p>
                    </div>
                </div>
            </div>

            <div class="card p-3 col-12 col-md-6 col-12 col-md-6 col-lg-4">
                <div class="card-wrapper media-container-row">
                    <div class="card-box">
                        <h4 class="card-title pb-3 mbr-fonts-style display-5">
                            <?php echo __d('mobirise/taxi-prices-cuba', 'Rápido')?></h4>
                        <p class="mbr-text mbr-fonts-style display-7">
                            <?php echo __d('mobirise/taxi-prices-cuba', 'Recibirás <strong>múltiples ofertas en menos de 12 horas</strong>. Todo depende del momento en que los choferes abran su app móvil o su correo. Si están interesados, responderán enseguida.')?></p>
                    </div>
                </div>
            </div>

            <div class="card p-3 col-12 col-md-6 col-lg-4">
                <div class="card-wrapper media-container-row">
                    <div class="card-box">
                        <h4 class="card-title pb-3 mbr-fonts-style display-5">
                            <?php echo __d('mobirise/taxi-prices-cuba', 'Sin compromisos')?></h4>
                        <p class="mbr-text mbr-fonts-style display-7">
                            <?php echo __d('mobirise/taxi-prices-cuba', 'Cuando recibes las ofertas puedes continuar comunicándote con los choferes que mejor te parezcan, pero <strong>no tienes que contratar a ninguno si no te parece bien</strong>.')?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="features16 cid-r6QXtixtYd" id="features16-c">
    <div class="container align-center">
        <h2 class="pb-3 mbr-fonts-style mbr-section-title display-5"><?php echo __d('mobirise/taxi-prices-cuba', 'Inspírate con %s historias escritas sobre nuestros choferes por clientes anteriores', $stats['reviews'])?></h2>
        <h3 class="pb-5 mbr-section-subtitle mbr-fonts-style mbr-light display-5"><?php echo __d('mobirise/taxi-prices-cuba', 'Podrás verlas en los perfiles de los choferes')?></h3>
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
                    <?php echo $this->Html->link(__d('mobirise/homepage', 'Mira opiniones recientes sobre nuestros choferes'), array('controller'=>'testimonials', 'action'=>'featured', '?'=>array('also'=>Configure::read('Config.language') == 'es'?'en':'es')), array('class'=>'btn btn-md btn-success-outline display-3'))?>
                </div>
            </div>
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
                <h2 class="mbr-section-title align-center pb-3 mbr-fonts-style display-6"><?php echo __d('mobirise/taxi-prices-cuba', 'Solicita presupuesto para taxi en Cuba')?></h2>
                <h3 class="mbr-section-subtitle align-center mbr-light pb-3 mbr-fonts-style display-5">
                    <?php echo __d('mobirise/taxi-prices-cuba', 'Envía la idea de tus recorridos a nuestros choferes')?>
                </h3>
                <!--<p class="align-center"><?php echo __d('mobirise/homepage', 'Recogida en aeropuerto, llegar directo a un destino, chofer a tiempo completo por varios días, tours a lo largo de la isla')?>...</p>-->
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
            <div class="carousel-inner" data-visible="5">
                
            <div class="carousel-item ">
                    <div class="media-container-row">
                        <div class="col-md-12">
                            <div class="wrap-img ">
                                <a href="https://huffingtonpost.com/scott-norvell/an-uber-for-cuba_b_6987824.html" target="_blank"><?php echo $this->Html->image('huffpost-logo-240x240.png', array('class'=>'img-responsive clients-img'))?></a>
                            </div>
                        </div>
                    </div>
                </div><div class="carousel-item ">
                    <div class="media-container-row">
                        <div class="col-md-12">
                            <div class="wrap-img ">
                                <a href="https://techcrunch.com/2015/10/06/cubas-startup-paradox/" target="_blank"><?php echo $this->Html->image('techcrunch-602x302.png', array('class'=>'img-responsive clients-img'))?></a>
                            </div>
                        </div>
                    </div>
                </div><div class="carousel-item ">
                    <div class="media-container-row">
                        <div class="col-md-12">
                            <div class="wrap-img ">
                                <a href="https://oncubanews.com/cuba/economia/yo-te-llevo-una-startup-cubana-que-despega/" target="_blank"><?php echo $this->Html->image('oncuba-224x225.png', array('class'=>'img-responsive clients-img'))?></a>
                            </div>
                        </div>
                    </div>
                </div><div class="carousel-item ">
                    <div class="media-container-row">
                        <div class="col-md-12">
                            <div class="wrap-img ">
                                <a href="https://www.eldiario.es/hojaderouter/internet/Cuba-revolucion_digital-tecnologia-internet-bloqueo_0_647435540.html" target="_blank"><?php echo $this->Html->image('eldiario.es-543x93.png', array('class'=>'img-responsive clients-img'))?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item ">
                    <div class="media-container-row">
                        <div class="col-md-12">
                            <div class="wrap-img ">
                                <a href="https://www.elconfidencial.com/tecnologia/2015-11-21/frente-al-aislamiento-creatividad-los-pioneros-de-las-startups-en-cuba_1102913/" target="_blank"><?php echo $this->Html->image('el-confidencial-610x406.png', array('class'=>'img-responsive clients-img'))?></a>
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

<?php echo $this->element('mobirise/share-page2')?>