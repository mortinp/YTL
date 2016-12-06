<?php 
   $webroot = $this->request->webroot;
   if( isset($testimonial['image_filepath']) && $testimonial['image_filepath'] != null )
      $testimonial_imagen_path = str_replace('\\', '/', $testimonial['image_filepath']);
   $urlConversation = array('controller' => 'driver_traveler_conversations', 'action' => 'view', $testimonial['conversation_id']);
   
   $states = array('P' => 'Pendiente', 'A' => 'Aprobado', 'R' => 'Rechazado');
   $statesClasses = array('P' => 'btn-default', 'A' => 'btn-success', 'R' => 'btn-danger'); 
   $idiomas = array('es' => '<img src="/yotellevo/img/Spain.png" alt="es"/>', 
                    'en' => '<img src="/yotellevo/img/UK.png" alt="es"/>');
   $langUrl = array('es' => array('controller' => 'testimonials', 'action' => "lang_change/{$testimonial['id']}/en"), 
                    'en' => array('controller' => 'testimonials', 'action' => "lang_change/{$testimonial['id']}/es") );
?>

<h2 align="center"> Administrar Testimonio #<?php echo $testimonial['id']; ?></h2>
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <?php 
        echo $this->element('testimonial_admin', array('testimonial' => $testimonial) ); 
        echo $this->element('testimonial_body', array('testimonial' => $testimonial) );
      ?>
    </div>    
  </div>    
</div>