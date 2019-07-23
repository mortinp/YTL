<?php
    $this->Paginator->options(array(
        'update' => '.ajax-load:last',
        'evalScripts' => true,
        'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
        'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false))
    ));
?>

<?php foreach($testimonials as $testimonial):?>
    <section class="testimonials3 cid-r6TeBtPTdm" id="testimonials3-o">
        <div class="container">
            <?php $hasReplies = isset($testimonial['TestimonialsReply']) && $testimonial['TestimonialsReply'] != null?>
            <?php echo $this->element('mobirise/testimonial-full', 
                            array('testimonial'=>$testimonial['Testimonial'], 
                            'driver'=>$testimonial['Driver'],
                            'driverReplies'=>$hasReplies?$testimonial['TestimonialsReply']:array()))?>
        </div>
    </section>
<?php endforeach;?>


<section class="mbr-section info1 cid-r6WrrCLwoE ajax-load" id="info1-19">
    
    <div class="container">
        <div class="row justify-content-center content-row">
            <div class="media-container-column col-12 col-lg-3 col-md-4">
                <div class="mbr-section-btn align-right py-4">
                    <?php
                    echo $this->Paginator->next(
                                __d('mobirise/driver_profile', 'Ver más opiniones'),
                                array('class'=>'btn btn-success display-4', 'style'=>'color:inherit'),
                                __d('mobirise/testimonials', 'No hay más opiniones'),
                                array('class'=>'alert text-muted'));
                    echo '<div id="busy-indicator" style="display:none"><big>'.$this->Html->image('loading.gif').'</big></div>';
                    
                    echo $this->Js->writeBuffer();
                    ?>
                </div>
            </div>
            
        </div>
    </div>
</section>