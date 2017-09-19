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



<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="lead"> <span class="text-muted">Administrar Testimonio #</span><?php echo $testimonial['id']; ?> <?php echo $this->Html->link('permalink »', array('language'=>$testimonial['lang'], 'controller' => 'testimonials', 'action' => 'view', $testimonial['id']), array('target'=>'_blank'))?></div>
      <?php 
        echo $this->element('testimonial_admin', array('testimonial' => $testimonial) ); 
        echo $this->element('testimonial_body', array('testimonial' => $testimonial) );
      ?>
    </div>    
  </div>    
</div>