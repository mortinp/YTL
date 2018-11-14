<section class="cid-r6STBfRkgW" id="footer5-j">
    <div class="container">
        <div class="media-container-row">
            <div class="col-md-3">
                <div class="media-wrap">
                    <?php echo $this->Html->link($this->Html->image('logo37.png', array('alt'=>'Yo Te Llevo Cuba logo')), '/'.SessionComponent::read('Config.language'), array('escape'=>false));?>
                </div>
            </div>
            <div class="col-md-9">
                <p class="mbr-text align-right links mbr-fonts-style display-7">
                    <em>
                        <b><?php echo $this->Html->link(__d('mobirise/default', 'OPINAR SOBRE CHOFER'), array('controller'=>'testimonials', 'action'=>'enter_code'), array('class'=>'text-white')); ?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php echo $this->Html->link(__d('mobirise/default', 'SOBRE NOSOTROS'), array('controller'=>'testimonials', 'action'=>'featured', '?'=>array('also'=>Configure::read('Config.language') == 'es'?'en':'es')), array('class'=>'text-white')); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php echo $this->Html->link(__d('mobirise/default', 'TESTIMONIOS'), array('controller'=>'testimonials', 'action'=>'featured', '?'=>array('also'=>Configure::read('Config.language') == 'es'?'en':'es')), array('class'=>'text-white')); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php echo $this->Html->link(__d('mobirise/default', 'CONTACTO'), array('controller'=>'pages', 'action'=>'display', 'contact'), array('class'=>'text-white')); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                    </em>
                </p>
            </div>
        </div>
        <div class="footer-lower">
            <div class="media-container-row">
                <div class="col-md-12">
                    <hr>
                </div>
            </div>
            <div class="media-container-row mbr-white">
                <div class="col-md-6 copyright">
                    <p class="mbr-text mbr-fonts-style display-7">
                        © Copyright 2018 Yo Te Llevo - Cuba
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