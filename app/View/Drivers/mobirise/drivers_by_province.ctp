<section class="header1 cid-rss8alYxEU mbr-fullscreen" id="header16-3g">

    <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(35, 35, 35);">
    </div>

    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-10 align-center">
                <h1 class="mbr-section-title mbr-bold pb-3 mbr-fonts-style display-1">Taxi &amp; Chofer en <span style="display: inline-block"><?php echo $province ?></span></h1>
                
                <p class="mbr-text pb-3 mbr-fonts-style display-5">Taxi a tiempo completo - Recogida en aeropuerto de <?php echo $province ?> - Tour por toda Cuba - Tour de un día a Viñales - Traslados desde <?php echo $province ?> a cualquier destino
<br>
<br><?php echo sizeof($drivers_data); ?> choferes activos</p>
                
            </div>
        </div>
    </div>

</section>

<section class="testimonials4 cid-rsmhu3OqyL" id="testimonials4-3c">
  
  <div class="container">
    
    <h3 class="mbr-section-subtitle mbr-light pb-3 mbr-fonts-style mbr-white align-center display-5">Estos choferes están disponibles para contratarlos para tus recorridos en Cuba comenzando en <?php echo $province ?>. <strong>Puedes preguntarles directamente por precios desde sus perfiles.</strong><br>
    </h3>
    <div class="row"> 
      <?php     
 
                 foreach ($drivers_data as $driver) {
      ?> 
        <div class="testimonials-item col-sm-5  col-md-3 col-lg-3 well center-block" style="background-color: white; margin-left: 30px; margin-bottom: 30px; border-radius: 3px">
            <div class="user">
              <div class="col-lg-8 col-md-6">
                <div class="user_image">
                  <img style='max-width>: 2em; max-heigh:3em' class='img-fluid img-responsive' src='<?php echo $driver['drivers_profiles']['featured_img_url']; ?>' alt='<?php echo $driver['drivers_profiles']['driver_name']; ?>' title='Foto del chofer <?php echo $driver['drivers_profiles']['driver_name']; ?>'>
                </div>
              </div>
              <div class="testimonials-caption">
                <div class="user_text ">
                  <p class="mbr-fonts-style  display-7">
                     <strong><?php echo $driver['drivers_profiles']['driver_name']; ?></strong><br><em><br></em><span class="fa fa-map-marker"></span> <?php echo $province ?><br>
                     <?php if ($driver['drivers']['has_modern_car']==true): ?><span title='auto moderno' class="fa fa-car"></span><?php endif; ?><?php if ($driver['drivers']['has_modern_car']==false): ?><span title='auto clásico' class="fa fa-taxi"></span><?php endif; ?> - <strong><?php echo $driver['drivers']['max_people_count']; ?> pax</strong> 
                     <?php if ($driver['drivers']['has_air_conditioner']==true): ?> | <span title="A/C" class="fa fa-snowflake-o"></span> <?php endif; ?>               
                    <br><br><?php echo $driver[0]['review_count']; ?> opiniones<br><?php echo $driver[0]['travel_count']; ?> contratos,<?php echo $driver[0]['total_travelers']; ?> clientes<em><br></em></p>
                    <p align="left"><a href="<?php echo $this->Html->url(array('controller'=>'drivers', 'action'=>'profile', $driver['drivers_profiles']['driver_nick'])) ?>" class="btn btn-sm btn-primary">Ver perfil <!--de <?php echo $driver['drivers_profiles']['driver_name']; ?>--></a></p>
                </div>
                
              </div>
            </div>
        </div>

        <?php } ?>
        
            
    </div>
  </div>
</section>

<?php echo $this->element('mobirise/share-page')?>