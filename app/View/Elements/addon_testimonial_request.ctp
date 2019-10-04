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
            <b><i style='padding: 5px; color:red!important' class='glyphicon glyphicon-heart'></i> Testimonio recibido</b>
            <?php echo $this->Html->link('Ver »', array('controller' => 'testimonials', 'action' => 'admin', $data['Testimonial']['id']), array('target'=>'_blank'))?>
        <?php else:?>
            <div class="testimonial-ajax-toggle" style="display: <?php echo ($solicitado) ? 'inline-block' : 'none'; ?>">
                <i style='padding: 5px' class='glyphicon glyphicon-heart-empty'></i>Solicitud de testimonio enviada al viajero!
            </div>

            <div class="testimonial-ajax-toggle" style="display: <?php echo ($solicitado) ? 'none' : 'inline-block'; ?>">
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
                
                <!--
   	        <?php echo $this->Form->button('<i style="padding: 5px" class="glyphicon glyphicon-heart-empty"></i> Solicitar testimonio al viajero', 
                    array(
                          'class'=>'btn-warning btn btn-block',
                          'data-dtype' => 'text',
                          'data-url' => $this->Html->url(array('controller' => 'testimonials', 'action' => 'request_testimonial', $data['DriverTravel']['id']), true),
                          'id' => 'testimonial-ajax-btn'
                    ), array('escape'=>false));
                ?>
                -->
                <?php echo $this->Form->create('Data', array('url' => array('controller' => 'testimonials', 'action' =>'request_testimonial', $data['DriverTravel']['id']))); ?>
                    <fieldset>
                    <?php
                    //echo $this->Form->input('conversation_id', array('type'=>'hidden'));
                    echo $this->Form->input('name', array('type'=>'text', 'label'=>'Nombre(s) de los viajeros'));

                    $langs = ($data['Travel']['User']['lang'] == 'es')? array('es'=>'Español', 'en'=>'English'): array('en'=>'English', 'es'=>'Español');
                    echo $this->Form->input('lang', array(
                        'options' => $langs
                    ));
                    echo $this->Form->submit('Solicitar testimonio al viajero', array('class'=>'btn-info btn btn-block', 'confirm' => 'Está a punto de enviar un correo de solicitud de testimonio al viajero. ¿Desea continuar?'));
                    ?>
                    </fieldset>
                <?php echo $this->Form->end(); ?>
            </div>
	    
        <?php endif;?>										
      
   </span>
</div>   
<?php endif; ?>

<?php
    echo $this->Html->script('ajaxify/buttons');
    $this->Html->script('jquery', array('inline' => false));
    echo $this->Js->writeBuffer(array('inline' => false));
?>

<script type="text/javascript">    
    ajaxifyButton( 
        $('#testimonial-ajax-btn'), 
        function(response){ $('.testimonial-ajax-toggle').toggle(); }, //success
        function(error){ alert(error.responseText); },                 //error
        'Está a punto de enviar un correo de solicitud de testimonio al viajero. ¿Desea continuar?'
    );
</script>