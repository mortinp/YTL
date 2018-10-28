<?php App::uses('LangUtil', 'Util')?>

<section class="mbr-section content5 cid-r6TcRZEk3l mbr-parallax-background" id="content5-n">
    <div class="mbr-overlay" style="opacity: 0.4; background-color: rgb(35, 35, 35);">
    </div>

    <div class="container">
        <div class="media-container-row">
            <div class="title col-12 col-md-8">
                <h2 class="align-center mbr-bold mbr-white pb-3 mbr-fonts-style display-1">
                    <br><?php echo __d('mobirise/testimonials', 'Opiniones sobre choferes de taxi en Cuba')?></h2>
            </div>
        </div>
    </div>
</section>

<section class="counters1 counters cid-r78ZyzVth3" id="counters1-24">

    <div class="container">
        
        <h3 class="mbr-section-subtitle mbr-fonts-style display-5">
            <?php echo __d('mobirise/testimonials', 'Desde Enero 2016, nuestros choferes han estado trabajando para lograr números como estos')?></h3>

        <div class="container pt-4 mt-2">
            <div class="media-container-row">
                <div class="card p-3 align-center col-12 col-md-6 col-lg-4">
                    <div class="panel-item p-3">
                        <div class="card-img pb-3">
                            <span class="mbr-iconfont mbri-like"></span>
                        </div>

                        <div class="card-text">
                            <h3 class="count pt-3 pb-3 mbr-fonts-style display-5"><?php echo __d('mobirise/testimonials', '%s contrataciones', $stats['hires'])?></h3>
                            
                            <p class="mbr-content-text mbr-fonts-style display-7"><?php echo __d('mobirise/testimonials', 'Nuestros choferes han sido contratados %s veces. Un contrato puede ser una simple recogida en aeropuerto, hasta un viaje de más de tres semanas por toda la isla.', '<strong>'.$stats['hires'].'</strong>')?></p>
                        </div>
                    </div>
                </div>


                <div class="card p-3 align-center col-12 col-md-6 col-lg-4">
                    <div class="panel-item p-3">
                        <div class="card-img pb-3">
                            <span class="mbr-iconfont mbri-briefcase"></span>
                        </div>
                        <div class="card-text">
                            <h3 class="count pt-3 pb-3 mbr-fonts-style display-5"><?php echo __d('mobirise/testimonials', '%s viajeros', $stats['people'])?></h3>
                            
                            <p class="mbr-content-text mbr-fonts-style display-7"><?php echo __d('mobirise/testimonials', 'Desde viajeros solitarios, hasta parejas de vacaciones, familias enteras, o grupos de más de 10 personas, %s viajeros han ido de viaje con nuestros choferes hasta ahora.', '<strong>'.$stats['people'].'</strong>')?></p>
                        </div>
                    </div>
                </div>

                <div class="card p-3 align-center col-12 col-md-6 col-lg-4">
                    <div class="panel-item p-3">
                        <div class="card-img pb-3">
                            <span class="mbr-iconfont mbri-image-slider"></span>
                        </div>
                        <div class="card-text">
                            <h3 class="count pt-3 pb-3 mbr-fonts-style display-5"><?php echo __d('mobirise/testimonials', '%s opiniones', $stats['reviews'])?></h3>
                            
                            <p class="mbr-content-text mbr-fonts-style display-7">
                                    <?php echo __d('mobirise/testimonials', 'Desde Diciembre 2016 comenzamos a recolectar opiniones, y %s comentarios han sido escritos sobre nuestros choferes, muchos con fotos incluídas.', '<strong>'.$stats['reviews'].'</strong>')?></p>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
   </div>
</section>

<section class="mbr-section article content9 cid-r6Tfi0B9Hg" id="content9-p">

    <div class="container">
        <div class="inner-container" style="width: 100%;">
            <hr class="line" style="width: 25%;">
            <div class="section-text align-center mbr-fonts-style display-5"><?php echo __d('mobirise/testimonials', 'Estas son algunas opiniones, comentarios e historias de viajeros que han hecho recorridos y traslados con nuestros choferes. Lee algunas, inspírate y anímate a contratar a algún chofer con auto aquí en Cuba.')?></div>
            <hr class="line" style="width: 25%;">
        </div>
    </div>
</section>

<section class="mbr-section article content9 cid-r6Tfi0B9Hg">

    <div class="container">
        <div class="inner-container" style="width: 100%;">
            <?php if((int)$this->Paginator->counter('{:pages}') > 1):?>
                <div class="section-text align-center mbr-fonts-style display-5" style="margin-bottom:0px !important;padding-bottom:0px !important">
                    <?php echo __d('testimonials', '%s historias aquí... y hay más', count($testimonials))?>: 
                    <span style="display: inline-block"><?php echo $this->Paginator->numbers(array('modulus'=>20));?></span>
                </div>

                <?php 
                $currentLang = LangUtil::getLangSetup(Configure::read('Config.language'));

                $proposeAltLang = 
                        !isset($this->request->query['also']) 
                        || Configure::read('Config.language') == $this->request->query['also']
                        || !in_array($this->request->query['also'], array('en', 'es'));

                $query = null;
                if(isset($this->request->query['in'])) $query = '?in='.$this->request->query['in'];
                ?>    
                <?php if($proposeAltLang):?>
                    <?php 
                    $query = '?also='.$currentLang['alt'];
                    if(isset($this->request->query['in'])) $query .= '&in='.$this->request->query['in'];
                    ?>
                    <div class="section-text align-center mbr-fonts-style display-4">
                        <span class="text-muted"><?php echo __d('testimonials', 'Descubre más choferes')?>:</span>
                        <span style="display: inline-block"><?php echo $this->Html->link(__d('testimonials', 'Mostrar también reseñas en %s', $currentLang['altDesc']), $query)?></span>
                    </div>
                <?php else:?>
                    <?php 
                    $query = '';
                    if(isset($this->request->query['in'])) $query .= '?in='.$this->request->query['in'];
                    ?>
                    <div class="section-text align-center mbr-fonts-style display-4">
                        <span class="text-muted"><?php echo __d('testimonials', 'Se muestran reseñas en %s e %s', $currentLang['desc'], $currentLang['altDesc'])?></span>
                        - <span><?php echo $this->Html->link(__d('testimonials', 'Mostrar sólo en %s', $currentLang['desc']), array('action'=>'featured'.$query) )?></span>
                    </div>
                <?php endif?>
            <?php endif?>
        </div>
    </div>
    
</section>


<?php foreach($testimonials as $i=>$data):?>
    <section class="testimonials3 cid-r6TeBtPTdm" id="testimonials3-o">
        <div class="container">
            <?php echo $this->element('mobirise/testimonial-full', array('testimonial'=>$data['Testimonial'], 'driver'=>$data['Driver']))?>
        </div>
    </section>

    <!-- Poner el formulario de solicitud despues del nth testimonio -->
    <?php if($i == 4):?>
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
    <?php endif?>


<?php endforeach;?>

<section class="mbr-section article content9 cid-r6Tfi0B9Hg">

    <div class="container">
        <div class="inner-container" style="width: 100%;">
            <div class="section-text align-center mbr-fonts-style display-5"><?php echo __d('mobirise/testimonials', 'Mira más historias')?>: <span style="display: inline-block"><?php echo $this->Paginator->numbers(array('modulus'=>20));?></span></div>
        </div>
    </div>
</section>

<?php echo $this->element('mobirise/share-page')?>