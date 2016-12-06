<?php
   $solicitado = isset( $data['TravelConversationMeta']['testimonial_requested'] ) &&
                        $data['TravelConversationMeta']['testimonial_requested'] > 0; 
   $pagado_realizado = isset( $data['TravelConversationMeta']['state'] ) && 
 	               in_array( $data['TravelConversationMeta']['state'], 
		         array(DriverTravelerConversation::$STATE_TRAVEL_PAID, DriverTravelerConversation::$STATE_TRAVEL_DONE) );
   
   $testimonial_received = isset($data['Testimonial']['id']) && $data['Testimonial']['id'] != null;
?>

<?php if($pagado_realizado): ?>
<div id="testimonial_addon">
   <span class="alert alert-warning" style="display: inline-block; width: 100%">
      <?php if($testimonial_received):?>
	    <b><i style='padding: 5px' class='glyphicon glyphicon-heart'></i> Testimonio recibido</b>
            <?php echo $this->Html->link('Ver »', array('controller' => 'testimonials', 'action' => 'admin', $data['Testimonial']['id']), array('target'=>'_blank'))?>
      <?php else:?>
        <?php if($solicitado):?>
	       <i style='padding: 5px' class='glyphicon glyphicon-heart-empty'></i> Solicitud de Testimonio enviada. Esperando respuesta...
            <?php else:?>
   	       <?php echo $this->Form->button('<i style="padding: 5px" class="glyphicon glyphicon-heart-empty"></i> Solicitar Testimonio', 
                    array('controller' => 'testimonials',
                          'action' => "request_testimonial/".$data['DriverTravel']['id'],
                          'confirm' => 'Está a punto de enviar un correo de Solicitud de Testimonio al viajero. ¿Desea continuar?',
                          'class'=>'btn-warning',
                          'escape'=>false
                    ));
                ?>
            <?php endif;?>
	    
        <?php endif;?>										
      
   </span>
</div>   
<?php endif; ?>