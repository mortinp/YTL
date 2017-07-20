<?php
   $solicitado = isset( $data['TravelConversationMeta']['testimonial_requested'] ) &&
                        $data['TravelConversationMeta']['testimonial_requested'] > 0; 
   $travelDone = isset( $data['TravelConversationMeta']['state'] ) && 
 	               in_array( $data['TravelConversationMeta']['state'], 
		         array(DriverTravelerConversation::$STATE_TRAVEL_PAID, DriverTravelerConversation::$STATE_TRAVEL_DONE) );
   
   $testimonial_received = isset($data['Testimonial']['id']) && $data['Testimonial']['id'] != null;
?>

<?php if($travelDone): ?>
<div id="testimonial_addon">
   <span class="alert alert-warning" style="display: inline-block; width: 100%">
      <?php if($testimonial_received):?>
	    <b><i style='padding: 5px' class='glyphicon glyphicon-heart'></i> Testimonio recibido</b>
            <?php echo $this->Html->link('Ver »', array('controller' => 'testimonials', 'action' => 'admin', $data['Testimonial']['id']), array('target'=>'_blank'))?>
      <?php else:?>
        <?php if($solicitado):?>
	       <i style='padding: 5px' class='glyphicon glyphicon-heart-empty'></i>Solicitud de testimonio enviada al viajero!
            <?php else:?>
                <p>
                    <b>Este viaje está <span class="label label-warning">Realizado</span></b>
                </p>
                <hr/>
                <p><b>No se ha enviado el pedido de testimonio al viajero</b></p>
                <p>La solicitud se debe enviar preferiblemente en los viajes que cumplan los siguientes requisitos:</p>
                <ul>
                    <li>Fue un viaje de varios días con el mismo chofer. De esta manera se logran mejores testimonios pues la relación es más estrecha.</li>
                    <li>Ya el viaje terminó hace algunos días. Es preferible que el viajero ya se encuentre de regreso en su país (5 días después es bueno).</li>
                    <li>No se han recibido quejas del cliente o del chofer.</li>
                </ul>
                <br/>
   	       <?php echo $this->Form->button('<i style="padding: 5px" class="glyphicon glyphicon-heart-empty"></i> Solicitar testimonio al viajero', 
                    array('controller' => 'testimonials',
                          'action' => "request_testimonial/".$data['DriverTravel']['id'],
                          'confirm' => 'Está a punto de enviar un correo de solicitud de testimonio al viajero. ¿Desea continuar?',
                          'class'=>'btn-warning btn btn-block',
                    ), array('escape'=>false));
                ?>
            <?php endif;?>
	    
        <?php endif;?>										
      
   </span>
</div>   
<?php endif; ?>