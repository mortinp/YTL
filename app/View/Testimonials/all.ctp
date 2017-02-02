<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h3>Testimonios (<?php echo count($testimonials)?>)</h3>
            
            <div>Páginas: <?php echo $this->Paginator->numbers();?></div>
            <br/>
            <?php echo $this->element('addon_filters_for_search', array('filters_for_search'=>Testimonial::$states))?>
            
            <!-- Resumen de cantidad de testimonios por choferes -->
            <div>
                <b>Resumen de esta página</b><hr/>
                <?php
                $results = array();
                foreach($testimonials as $data) {
                    if(!array_key_exists($data['Driver']['id'], $results)) {
                        $subject = $data['Driver']['id'];
                        $count = 0;
                        foreach($testimonials as $again) {
                            if($again['Driver']['id'] == $subject) $count ++;
                        }
                        $results[$subject] = array(
                            'driver_name' => $data['Driver']['DriverProfile']['driver_name'],
                            'driver_nick' => $data['Driver']['DriverProfile']['driver_nick'],
                            'driver_avatar' => $this->request->webroot.str_replace('\\', '/', $data['Driver']['DriverProfile']['avatar_filepath']),
                            'testimonials_count'=>$count);
                    }
                } 
                ?>
                
                <ul class="list-inline">
                <?php foreach($results as $r):?>
                    <li style="text-align: center"><img src="<?php echo $r['driver_avatar']?>" title="<?php echo $r['driver_name']?>" class="info img-responsive" style="max-width: 40px "/> 
                    <big><b><?php echo $this->Html->link($r['testimonials_count'], array('controller'=>'drivers', 'action'=>'profile/'.$r['driver_nick']), array('target'=>'_blank'))?></b></big></li>
                <?php endforeach?>
                </ul>
                <hr/>
            </div>
                
            
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