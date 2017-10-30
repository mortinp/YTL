function ajaxifyButton(button, onSuccess, onError, confirmMessage) {
	
    button.click(function( event ) {
        // Para que el boton no haga nada por defecto
        event.preventDefault();
        
        if( confirmMessage == null || confirm(confirmMessage) ){
            var returnType = $(this).data('dtype');
            if(returnType == null ) returnType = 'json';

            // Deshabilitar boton y poner Espere...
            var boton = $(this);
            //var prevText = boton.text();
            boton.attr('disabled', true);
            //boton.text('Espere ...');

            $.ajax({
                type: "POST",
                dataType: returnType,
                url: $(this).data('url'),
                success: function(response) {
                    if(onSuccess)
                        onSuccess(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if(onError)
                        onError(jqXHR);
                },
                complete: function(){
                    // Habilitar boton y restaurar texto
                    boton.attr('disabled', false);
                    //boton.text(prevText);
                }
            });
        }
    });
}