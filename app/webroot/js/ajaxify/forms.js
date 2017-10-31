/**
 * Esta funcion hace que un formulario envie los datos por AJAX. Los datos se envian a la misma url definida en la propiedad 'action' del formulario.
 *
 * @param form: El formulario ej. $('#formulario')
 * @param obj:  Un objeto que contendrá valores por defecto o preexistentes del modelo que se pretende crear o editar en el formulario.
 * Si el formulario tiene ya los valores, se puede pasar null.
 * @param onSuccess: una funcion que recibe el resultado del submit del formulario en un objeto que contiene los nuevos datos. Los nombres de los
 * campos en el objeto son los mismos nombres de los id de los campos del formulario.
 * @param onError: una funcion que recibe el jqXHR de la respuesta de error del submit del formulario
 **/
function _ajaxifyForm(form, obj, onSuccess, onError) {
    if(obj != null) setupFormForEdit(form, obj, alias);
    
    var btnSubmit = form.find('.submit').find('input');

    var doAjax = true /*form.attr('onsubmit') != '' && form.attr('onsubmit') != null && form.attr('onsubmit') != undefined*/;// Esto es un hack, pero pincha bien!
    if(doAjax == true) {
        form.submit(function(event) {
            event.preventDefault();
            if((form).valid == undefined || (form).valid()) {
                // Disable submit button
                var prevText = btnSubmit.val();
                btnSubmit.attr('disabled', true);
                btnSubmit.val('Espere ...');
               
                $.ajax({
                    type: "POST",
                    data: $(this).serialize(),
                    url: $(this).attr('action'),
                    success: function(response) {
                        response = JSON.parse(response);

                        if(onSuccess) {
                            if(response != null && typeof response === 'object' && response.object != null) 
                                onSuccess(response.object);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        if(onError) {
                            onError(jqXHR);
                        }
                    },
                    complete: function() {
                        btnSubmit.attr('disabled', false);
                        btnSubmit.val(prevText);
                    }
                });
            }
            
        });
    }
}


function setupFormForEdit(form, obj, alias) {
    if(obj.id == null) return; // TODO: throw exception???

    var upperAlias = capitalizarAlias(alias);
    for(k in obj) {
        var upperFieldName = capitalizarAlias(k);
        var input = form.find('#' + upperAlias + upperFieldName);
        input.val(obj[k]);
    }
    form.attr('action', form.attr('action').replace('/add', '/edit/' + obj.id));
}

function capitalizarAlias(alias) {
    return splitWith(alias, "");
}

function stringifyAlias(alias) {
    return splitWith(alias, " ");
}

function splitWith(alias, separator) {
    result = "";

    parts = alias.split("_");
    sep = "";
    for (p in parts) {
        result += sep + parts[p].substring(0, 1).toUpperCase() + parts[p].substring(1, parts[p].length);
        sep = separator;
    }

    return result;
}