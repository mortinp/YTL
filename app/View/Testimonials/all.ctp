<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h3>Testimonios (<?php echo count($testimonials)?>)</h3>
            
            <div>Páginas: <?php echo $this->Paginator->numbers();?></div>
            <br/>
            <?php echo $this->element('addon_filters_for_search', array('filters_for_search'=>Testimonial::$states))?>
            
            <?php if(!empty ($testimonials)): ?>
                <br/>
                <br/>
                <!-- body -->
                <?php
                   foreach($testimonials as $data){
                      $pass = array('testimonial' => $data['Testimonial'], 'driver' => $data['Driver']);
                      if( isset($data['Driver']['DriverProfile']['avatar_filepath']) )
                         $pass = array_merge($pass, array('driver_profile' => $data['Driver']['DriverProfile']));

                      if( isset($data['DriverTravel']['Travel']) )
                         $pass = array_merge($pass, array('travel' => $data['DriverTravel']['Travel'], 'user' => $data['DriverTravel']['Travel']['User']));

                      echo $this->element('testimonial_index', $pass);
                      echo '<br/><hr/>';
                   }   
                ?>
                
        <?php else :?>
            No hay testimonios
        <?php endif; ?>
            <div>Páginas: <?php echo $this->Paginator->numbers();?></div>
        </div>

    </div>
</div>