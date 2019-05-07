<div>
    <?php echo $this->Form->create('TravelConversationMeta', array('id'=>'contactForm','url' => array('controller' => 'driver_traveler_conversations', 'action' =>'direct_messaging_to_driver'))); ?>
    <fieldset>
        <?php        
        echo $this->Form->input('conversation_id', array('id'=>'conversation_id','type' => 'hidden', 'value' => $data['DriverTravel']['id']));
        echo $this->Form->input('body', array('id'=>'body','type'=>'textarea', 'class'=>'input-sm', 'label'=>'Escriba el mensaje'));
        echo $this->Form->button('Enviar',array('id'=>'driverwrite'));
        ?>        
    </fieldset>
    <?php echo $this->Form->end(); ?>
</div>

<?php
 echo "<script type='text/javascript'>"." var url ='".$this->Html->url(array('controller' => 'driver_traveler_conversations', 'action' => 'direct_messaging_to_driver', true))."';   </script>";
 

 echo "<script type='text/javascript'> 
       $('#driverwrite').on('click',function(e) {     
    
           var id = $('#conversation_id').val();
           var body = $('#body').val();
           
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    id: id,
                    body: body                    
                },
                cache: false, 
                
success: function(msg) {
                    // Success message                    
                    if( (msg=='true') || (msg=='1') ){                    
                    $('#successMSG').html(\"<div class='alert alert-info'>\");
                    $('#successMSG > .alert-info').html(\"<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>\");
                    $('#successMSG > .alert-info').append('<strong>Su mensaje se ha enviado!');
                    $('#successMSG > .alert-info').append('</div>'); 
                     $('#contactForm').trigger('reset');
                     }else{
                     $('#successMSG').html(\"<div class='alert alert-danger'>\");
                    $('#successMSG > .alert-danger').html(\"<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>\");
                    $('#successMSG > .alert-danger').append('<strong>Lo sentimos, su mensaje no pudo ser enviado. Intente nuevamente!');
                    $('#successMSG > .alert-danger').append('</div>'); 
                   }                    
                },
                error: function(msg) {
                   
                    $('#successMSG').html(\"<div class='alert alert-danger'>\");
                    $('#successMSG > .alert-danger').html(\"<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>\");
                    $('#successMSG > .alert-danger').append('<strong>Lo sentimos, su mensaje no pudo ser enviado. Intente nuevamente!');
                    $('#successMSG > .alert-danger').append('</div>');
                    //clear all fields
                    //$('#contactForm').trigger('reset');
                } 
                
            });
    });
    
</script>";
 
 /*A PONER PARA MENSAJE DE ENVIADO O FALLO
success: function(msg) {
                    // Success message                    
                    if( (msg=='true') || (msg=='1') ){
                    
                   }else{
                       $('#success').html('<div class='alert alert-danger'>');
                    $('#success > .alert-danger').html('<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>');
                    $('#success > .alert-danger').append('<strong>Lo sentimos, su mensaje no pudo ser enviado. Intente nuevamente!');
                    $('#success > .alert-danger').append('</div>'); 
                   }                    
                },
                error: function(msg) {
                   
                    $('#success').html('<div class='alert alert-danger'>');
                    $('#success > .alert-danger').html('<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>');
                    $('#success > .alert-danger').append('<strong>Lo sentimos, su mensaje no pudo ser enviado. Intente nuevamente!');
                    $('#success > .alert-danger').append('</div>');
                    //clear all fields
                    //$('#contactForm').trigger('reset');
                }  */
?>

