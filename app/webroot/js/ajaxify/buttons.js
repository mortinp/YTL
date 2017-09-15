function ajaxifyButton(button, onSuccess, onError) {
	
    button.click(function( event ) {

        // Para que el boton no haga nada por defecto
        event.preventDefault();

        // Deshabilitar boton y poner Espere...
        var boton = $(this);
        var prevText = boton.text();
        boton.attr('disabled', true);
        boton.text('Espere ...');

        $.ajax({
            type: "POST",
            //data: <Si vas a enviar datos habria que buscar la forma, pero por ahora creo que no se envia nada>,
            url: $(this).data('url'),
            success: function(response) {
                if(response == "") response = "{}";
                response = JSON.parse(response);

                if(onSuccess) {
                    if(response != null && typeof response === 'object') 
                        onSuccess(response);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                if(onError) {
                    onError(jqXHR);
                }
            },
            complete: function(){
                // Habilitar boton y restaurar texto
                boton.attr('disabled', false);
                boton.text(prevText);
            }
        });
    });
}