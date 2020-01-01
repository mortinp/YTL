<section class="cid-rtpwErX4BV" id="footer1-3s">
    <div class="container">
        <div class="media-container-row content text-white">
            <div class="col-12 col-md-3">
                <div class="media-wrap">
                    <?php echo $this->Html->link($this->Html->image('logo37.png', array('alt'=>'Yo Te Llevo Cuba logo')), '/'.SessionComponent::read('Config.language'), array('escape'=>false));?>
                </div>
            </div>
            <div class="col-12 col-md-3 mbr-fonts-style display-7">
                <h5 class="pb-3">
                    <?php echo __d('mobirise/default', 'Sobre Nosotros')?>
                </h5>
                <p class="mbr-text">
                    <?php echo __d('mobirise/default', 'YoTeLlevo es una <b>comunidad de choferes de taxi privado en Cuba</b>. Los contactas antes de llegar a la isla y te dan sus precios para tus traslados en Cuba.')?>
                </p>
                <p class="mbr-text">
                    <?php echo __d('mobirise/default', 'También somos los creadores de %s, un servicio de taxi compartido en Cuba.', '<a href="https://pickocar.com" class="text-white">PickoCar.com</a>')?>
                </p>
            </div>
            <div class="col-12 col-md-3 mbr-fonts-style display-7">
                <h5 class="pb-3">
                    <?php echo __d('mobirise/default', 'Enlaces')?>
                </h5>
                <p class="mbr-text">
                    <?php echo $this->Html->link(__d('mobirise/default', 'OPINAR SOBRE CHOFER'), array('controller'=>'testimonials', 'action'=>'enter_code'), array('class'=>'text-white')); ?>
                    <br>
                    <?php echo $this->Html->link(__d('mobirise/default', 'SOBRE NOSOTROS'), array('controller'=>'testimonials', 'action'=>'featured', '?'=>array('also'=>Configure::read('Config.language') == 'es'?'en':'es')), array('class'=>'text-white')); ?>
                    <br>
                    <?php echo $this->Html->link(__d('mobirise/default', 'TESTIMONIOS'), array('controller'=>'testimonials', 'action'=>'featured', '?'=>array('also'=>Configure::read('Config.language') == 'es'?'en':'es')), array('class'=>'text-white')); ?>
                    <br>
                    <?php echo $this->Html->link(__d('mobirise/default', 'CONTACTO'), array('controller'=>'pages', 'action'=>'display', 'contact'), array('class'=>'text-white')); ?>
                    <br>
                    <?php
                    $urlBlog = Configure::read('App.fullBaseUrl');
                    if(Configure::read('debug') > 0) {
                        $urlBlog .= '/yotellevo/app/webroot/blog';
                    } else {
                        $urlBlog .= '/blog';
                    }
                    $urlBlog .= '/'.Configure::read('Config.language');
                    ?>
                    <a href="<?php echo $urlBlog ?>" class="text-white">BLOG</a>
                </p>
            </div>
            <div class="col-12 col-md-3 mbr-fonts-style display-7">
                <h5 class="pb-3">
                    <?php echo __d('mobirise/default', 'Taxi en %s', 'Cuba')?>
                </h5>
                <p class="mbr-text">
                    <?php echo $this->Html->link(__d('mobirise/default', 'Taxi en %s', __('La Habana')), array('controller'=>'drivers', 'action'=>'drivers_by_province', 'la-habana'), array('class'=>'text-white')); ?>
                    <br>
                    <?php echo $this->Html->link(__d('mobirise/default', 'Taxi en %s', 'Viñales'), array('controller'=>'drivers', 'action'=>'drivers_by_province', 'vinales-pinar-del-rio'), array('class'=>'text-white')); ?>
                    <br>
                    <?php echo $this->Html->link(__d('mobirise/default', 'Taxi en %s', 'Varadero, Matanzas'), array('controller'=>'drivers', 'action'=>'drivers_by_province', 'varadero-matanzas'), array('class'=>'text-white')); ?>
                    <br>
                    <?php echo $this->Html->link(__d('mobirise/default', 'Taxi en %s', 'Trinidad, Santi Spíritus'), array('controller'=>'drivers', 'action'=>'drivers_by_province', 'trinidad-sancti-spiritus'), array('class'=>'text-white')); ?>
                    <br>
                    <?php echo $this->Html->link(__d('mobirise/default', 'Taxi en %s', 'Cienfuegos'), array('controller'=>'drivers', 'action'=>'drivers_by_province', 'cienfuegos'), array('class'=>'text-white')); ?>
                    <br>
                    <?php echo $this->Html->link(__d('mobirise/default', 'Taxi en %s', 'Cayo Coco/Guillermo'), array('controller'=>'drivers', 'action'=>'drivers_by_province', 'cayo-coco-guillermo-ciego-de-avila'), array('class'=>'text-white')); ?>
                    <br>
                    <?php echo $this->Html->link(__d('mobirise/default', 'Taxi en %s', 'Santiago de Cuba'), array('controller'=>'drivers', 'action'=>'drivers_by_province', 'santiago-de-cuba'), array('class'=>'text-white')); ?>
                    <br>
                    <?php echo $this->Html->link(__d('mobirise/default', 'Taxi en %s', 'Holguín'), array('controller'=>'drivers', 'action'=>'drivers_by_province', 'holguin-guardalavaca'), array('class'=>'text-white')); ?>
                </p>
            </div>
        </div>
        <div class="footer-lower">
            <div class="media-container-row">
                <div class="col-sm-12">
                    <hr>
                </div>
            </div>
            <div class="media-container-row mbr-white">
                <div class="col-sm-6 copyright">
                    <p class="mbr-text mbr-fonts-style display-7">
                        © Copyright 2020 Yo Te Llevo - Cuba
                    </p>
                </div>
                <div class="col-md-6">
                    <div class="social-list align-right">
                        <div class="soc-item">
                            <a href="https://www.facebook.com/yotellevoTaxiCuba" target="_blank">
                                <span class="mbr-iconfont mbr-iconfont-social socicon-facebook socicon" style="color: rgb(255, 255, 255); fill: rgb(255, 255, 255);"></span>
                            </a>
                        </div>
                        <div class="soc-item">
                            <a href="https://twitter.com/yotellevocuba" target="_blank">
                                <span class="mbr-iconfont mbr-iconfont-social socicon-twitter socicon" style="color: rgb(255, 255, 255); fill: rgb(255, 255, 255);"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>