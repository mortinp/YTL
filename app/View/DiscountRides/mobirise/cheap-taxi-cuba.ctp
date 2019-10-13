<section class="header1 cid-rCIPKaPIfg mbr-parallax-background" id="header1-3v">
    <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(35, 35, 35);">
    </div>

    <div class="container">
        <div class="row justify-content-md-center">
            <div class="mbr-white col-md-10">
                <h1 class="mbr-section-title align-center mbr-bold pb-3 mbr-fonts-style display-5">
                    <br><?php echo __d('mobirise/cheap_taxi', '¿Buscas taxi económico en Cuba?')?></h1>
                <h3 class="mbr-section-subtitle align-center mbr-light pb-3 mbr-fonts-style display-2"><strong>
                    <?php echo __d('mobirise/cheap_taxi', 'Encuentra taxi privado en Cuba por la mitad del precio estándar')?></strong></h3>
                <p class="mbr-text align-center pb-3 mbr-fonts-style display-5"><?php echo __d('mobirise/cheap_taxi', 'Nuestros choferes hacen ofertas de 50% de descuento en algunas ocasiones. Nosotros las listamos aquí y tú puedes reservarlas.')?></p>
                <div class="mbr-section-btn align-center">
                    <a class="btn btn-md btn-secondary display-4" href="#<?php echo __d('mobirise/default', 'solicitar')?>">
                        <span class="mbri-gift mbr-iconfont mbr-iconfont-btn"></span>
                        <?php echo __d('mobirise/cheap_taxi', 'Ver traslados disponibles con 50% de descuento')?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="header1 cid-rDhwWtMbYM" id="header16-4a">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-10 align-center">
                <h1 class="mbr-section-title mbr-bold pb-3 mbr-fonts-style display-2">
                    <span style="font-weight: normal;">
                        <?php echo __d('mobirise/cheap_taxi', '¿Por qué los choferes ofertan traslados con un descuento tan grande?')?>
                    </span>
                </h1>
                
                <p class="mbr-text pb-3 mbr-fonts-style display-5">
                    <?php echo __d('mobirise/cheap_taxi', 'En ocasiones los choferes están obligados a realizar un recorrido con el taxi vacío. Por ejemplo, <b>cuando dejan clientes lejos y tienen que regresar a casa</b>, o <b>cuando tienen que recoger clientes y deben salir desde un punto lejano</b>.')?>
                    <br>
                    <?php echo __d('mobirise/cheap_taxi', 'Cuando no tienen pasajeros contratados para estos recorridos, <b>los choferes prefieren al menos llevar a algunos por la mitad del precio, y amortiguar gastos de ese traslado</b>.')?>
                </p>
                <div class="mbr-section-btn">
                    <a class="btn btn-md btn-black-outline display-4" href="#<?php echo __d('mobirise/default', 'solicitar')?>">
                        <?php echo __d('mobirise/cheap_taxi', 'Ver ofertas disponibles')?>
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
                            <?php echo __d('mobirise/cheap_taxi', 'No hay que compartir taxi')?></h4>
                        <p class="mbr-text mbr-fonts-style display-7">
                            <?php echo __d('mobirise/cheap_taxi', 'Recibirás un servicio de taxi privado sin tener que compartirlo con otros pasajeros.')?></p>
                    </div>
                </div>
            </div>

            <div class="card p-3 col-12 col-md-6 col-12 col-md-6 col-lg-4">
                <div class="card-wrapper media-container-row">
                    <div class="card-box">
                        <h4 class="card-title pb-3 mbr-fonts-style display-5">
                            <?php echo __d('mobirise/cheap_taxi', 'Servicio puerta a puerta')?></h4>
                        <p class="mbr-text mbr-fonts-style display-7">
                            <?php echo __d('mobirise/cheap_taxi', 'El taxi te recoge en tu estancia u hotel y te lleva directamente hasta tu próximo destino.')?></p>
                    </div>
                </div>
            </div>

            <div class="card p-3 col-12 col-md-6 col-lg-4">
                <div class="card-wrapper media-container-row">
                    <div class="card-box">
                        <h4 class="card-title pb-3 mbr-fonts-style display-5">
                            <?php echo __d('mobirise/cheap_taxi', 'Contacto directo con el chofer')?></h4>
                        <p class="mbr-text mbr-fonts-style display-7">
                            <?php echo __d('mobirise/cheap_taxi', 'Contacta directamente con el chofer para acordar cualquier detalle extra sobre el viaje.')?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="accordion1 cid-rDipwYmLGU" id="<?php echo __d('mobirise/default', 'solicitar')?>">
    <div class="container">
        <div class="media-container-row">
            <div class="col-12">
                <div class="section-head text-center space30">
                    <div class="section-head text-center space30">
                        <h2 class="mbr-section-title pb-5 mbr-fonts-style display-2">
                            <?php echo __d('/mobirise/cheap_taxi', 'Encuentra tu oportunidad de ahorrar en taxi')?>
                        </h2>
                        <h3><?php echo __d('/mobirise/cheap_taxi', 'Busca según las fechas que necesitas trasladarte')?></h3>
                        <br/>
                        <div><?php echo __d('/mobirise/cheap_taxi', 'Todos los precios son totales, NO por persona', 4)?></div>
                        <div><?php echo __d('/mobirise/cheap_taxi', 'Las fechas y horarios son fijos y no tienen modificación')?></div>
                        <br/>
                    </div>
                </div>
                <div class="clearfix"></div>
                
                <div id="bootstrap-accordion_3" class="panel-group accordionStyles accordion" role="tablist" aria-multiselectable="true">
                    <?php echo $this->element('mobirise/discounts/all_offers', array('discounts'=>$discount_rides_by_date))?>
                </div>
                
            </div>
        </div>
    </div>
</section>

<section class="features16 cid-r6QXtixtYd" id="features16-c">
    <div class="container align-center">
        <h2 class="pb-3 mbr-fonts-style mbr-section-title display-5"><?php echo __d('mobirise/cheap_taxi', 'Trabajamos con una comunidad de taxistas independientes geniales')?></h2>
        <h3 class="pb-5 mbr-section-subtitle mbr-fonts-style mbr-light display-5"><?php echo __d('mobirise/cheap_taxi', 'Inspírate con %s historias escritas sobre nuestros choferes por clientes anteriores', $stats['reviews'])?></h3>
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
                    <?php echo $this->Html->link(__d('mobirise/cheap_taxipage', 'Mira opiniones recientes sobre nuestros choferes'), array('controller'=>'testimonials', 'action'=>'featured', '?'=>array('also'=>Configure::read('Config.language') == 'es'?'en':'es')), array('class'=>'btn btn-md btn-success-outline display-3'))?>
                </div>
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