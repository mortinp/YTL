/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
                    if(msg=='true' || msg=='1'){
                    $('#success').html('<div class='alert alert-success'>');
                    $('#success > .alert-success').html('<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;')
                        .append('</button>');
                    $('#success > .alert-success')
                        .append('<strong>Su mensaje se ha enviado. Gracias.</strong>');
                    $('#success > .alert-success')
                        .append('</div>');
                //clear all fields
                    $('#contactForm').trigger('reset');
                   }else{
                       $('#success').html('<div class='alert alert-danger'>');
                    $('#success > .alert-danger').html('<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;')
                        .append('</button>');
                    $('#success > .alert-danger').append('<strong>Lo sentimos ' + firstName + ', su mensaje no pudo ser enviado. Intente nuevamente!');
                    $('#success > .alert-danger').append('</div>'); 
                   }                    
                },
                error: function(msg) {
                   
                    $('#success').html('<div class='alert alert-danger'>');
                    $('#success > .alert-danger').html('<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;')
                        .append('</button>');
                    $('#success > .alert-danger').append('<strong>Lo sentimos ' + firstName + ', su mensaje no pudo ser enviado. Intente nuevamente!');
                    $('#success > .alert-danger').append('</div>');
                    //clear all fields
                    //$('#contactForm').trigger('reset');
                }
            });
    });


