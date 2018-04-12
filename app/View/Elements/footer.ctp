<div class="row">
    
    <div class="col-md-3">
        <p class="text-muted pull-left" style="margin: 20px 0;">
            &copy; 2015-2018 <?php echo __('YoTeLlevo')?>
        </p>
    </div>
    
    <div class="col-md-6" style="text-align: center">
        <p class="text-muted" style="margin: 20px 0;">
            <?php
            $urlBlog = Configure::read('App.fullBaseUrl');
            if(Configure::read('debug') > 0) {
                $urlBlog .= '/yotellevo/app/webroot/blog';
            } else {
                $urlBlog .= '/blog';
            }
            $urlBlog .= '/'.Configure::read('Config.language');
            ?>
            
            <?php echo $this->Html->link(__('Testimonios'), array('controller'=>'testimonials', 'action'=>'featured')); ?>
            |
            
            <?php echo $this->Html->link(__('Contactar'), array('controller'=>'pages', 'action'=>'display', 'contact')); ?>
            |
            
            <?php echo $this->Html->link(__('Preguntas Frecuentes'), array('controller'=>'pages', 'action'=>'display', 'faq')); ?>
            |
            
            <a href="<?php echo $urlBlog ?>" title="YoTeLlevo Blog">Blog</a>
            |
            
            <a href="https://www.facebook.com/yotellevoTaxiCuba" title="YoTeLlevo in Facebook">Facebook</a>
           
        </p>
    </div>

    <div class="col-md-3">
        <div class="pull-right" style="margin: 20px 0;">
            <span class="social-button small-social-button"><a rel="nofollow" class="twitter" target="_blank" href="https://twitter.com/home?status=<?php echo __('Aseg%C3%BArate%20de%20tener%20el%20mejor%20%23chofer%20con%20%23auto%20en%20%23Cuba%20en%20http://yotellevocuba.com%0A%0A%23Taxi%20para%20%23excursiones%20y%20%23transfers%20via%20%40yotellevocuba')?>">Tweet</a></span>
            <span class="social-button small-social-button"><a rel="nofollow" class="google" target="_blank" href="https://plus.google.com/share?url=http://yotellevocuba.com">+1</a></span>
            <span class="social-button small-social-button"><a rel="nofollow" class="facebook" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http://yotellevocuba.com">Like</a></span>
        </div>
    </div>

</div>