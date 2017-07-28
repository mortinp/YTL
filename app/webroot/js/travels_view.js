var messages = {
    success: {  es:'Los datos del viaje fueron salvados exitosamente.', en:'This travel was successfully updated.'},
    traveler: {es:'persona', en:'traveler'},
    preferencesLabel: {es:'Preferencias', en:'Preferences'}};



/**
 * Esta funcion hace que un formulario envie los datos por AJAX. Los datos se envian a la misma url definida en la propiedad 'action' del formulario.
 *
 * @param form: El formulario ej. $('#formulario')
 * @param obj:  Un objeto que contendría valores por defecto o preexistentes del modelo que se pretende crear o editar en el formulario.
 * Si el formulario tiene ya los valores, se puede pasar null.
 * @param alias: El alias del objeto. Este alias se usa para inferir el id de algunos elementos del formulario:
 * - Boton Submit [Alias]Submit (el alias con la primera letra mayuscula)
 * @param onSuccess: una funcion que recibe el resultado del submit del formulario en un objeto que contiene los nuevos datos. Los nombres de los
 * campos en el objeto son los mismos nombres de los id de los campos del formulario, pero sin el [Alias] al final. O sea, si hay un campo cuyo id es
 * 'TravelDescription' y el alias es 'travel', entonces el objeto tiene un campo con nombre 'description'.
 * @param onError: una funcion que recibe el jqXHR de la respuesta de error del submit del formulario
 **/
function _ajaxifyForm(form, obj, alias, onSuccess, onError) {
    if(obj != null) setupFormForEdit(form, obj, alias);

    var upperAlias = alias[0].toUpperCase() + alias.substring(1);

    var doAjax = form.attr('onsubmit') != '' && form.attr('onsubmit') != null && form.attr('onsubmit') != undefined;// Esto es un hack, pero pincha bien!
    if(doAjax == true) {
        form.submit(function() {
            if((form).valid()) {
                // Disable submit button
                var prevText = $('#' + upperAlias + 'Submit').val();
                $('#' + upperAlias + 'Submit').attr('disabled', true);
                $('#' + upperAlias + 'Submit').val('Espere ...');
               
                $.ajax({
                    type: "POST",
                    data: $(this).serialize(),
                    url: $(this).attr('action'),
                    success: function(response) {
                        response = JSON.parse(response);

                        if(onSuccess) {
                            if(response != null && typeof response === 'object' && response.object != null) 
                                onSuccess(response.object);
                            else {
                                var inputs = form.find('input, textarea');
                                var obj = {};
                                $.each(inputs, function(k, v){
                                    elem = $(v);
                                    if(elem.attr('id') == null) return;
                                    entryName = elem.attr('id').replace(upperAlias, '').toLowerCase();
                                    obj[entryName] = elem.val();
                                });
                                onSuccess(obj);
                            }
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        if(onError) {
                            onError(jqXHR);
                        }
                    },
                    complete: function() {
                        $('#' + upperAlias + 'Submit').attr('disabled', false);
                        $('#' + upperAlias + 'Submit').val(prevText);
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



$(document).ready(function() {
    var months = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    var weekDays = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");

    if(window.app.lang == 'en') {
        months = new Array ("January","February","March","April","May","June","July","August","September","October","November","December");
        weekDays = new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
    }
    
    _ajaxifyForm($("#TravelForm"), null, "travel", 
    
        // onSuccess
        function(obj) {

            var messageDiv = $('#travel-ajax-message');
            messageDiv.empty().append($("<div class='alert alert-success'>" + messages.success[window.app.lang] + "</div>"));
            setTimeout(function(){
                messageDiv.empty();
            }, 5000);

            $('#travel-locality-label').text(obj.origin);
            $('#travel-where-label').text(obj.destination);

            var d = obj.date.split('/');
            var dd = new Date(d[1] + '/' + d[0] + '/' + d[2]);
            var prettyDate = dd.getDate() + ' ' + months[dd.getMonth()] + ', ' + dd.getFullYear() + ' (' + weekDays[dd.getDay()] + ')';
            $('#travel-date-label').text(prettyDate);

            var prettyPeopleCount = obj.people_count + ' ' + messages.traveler[window.app.lang];
            if(obj.people_count > 1) prettyPeopleCount += 's';
            $('#travel-prettypeoplecount-label').text(prettyPeopleCount);

            var prefDiv = $('#preferences-place');
            prefDiv.empty();
            if(hasPreferences(obj)) {
                var prefText = messages.preferencesLabel[window.app.lang];
                prefDiv.append("<p><b>" + prefText + ":</b> <span id='travel-preferences-label'></span></p>");

                var prefLabel = $('#travel-preferences-label');
                prefLabel.text('');
                var sep = '';
                for(var p in window.app.travels_preferences) {
                    if(obj[p] == "1") {
                        prefLabel.text(prefLabel.text() + sep + window.app.travels_preferences[p]);
                        sep = ', ';
                    }
                }
                prefDiv.show();
            } else {
                prefDiv.empty();
                prefDiv.hide();
            }        

            $('#travel-details-label').text(obj.details);

            if(obj.email !== undefined) {
                $('#travel-email-label').text(obj.email);
                $('#UserUsername').val(obj.email);
                $('#UserFakeUsername').val(obj.email);
                $('#UserPassword').focus();
            }

            $('#travel-form, #travel').toggle();
        }, 


        // onError
        function(jqXHR) {
            var messageDiv = $('#travel-ajax-message');
            messageDiv.append("<div class='alert alert-danger'>" + jqXHR.responseText + "</div>");
            setTimeout(function(){
                messageDiv.empty();
            }, 5000);
        }
        
    );

    $('.edit-travel, .cancel-edit-travel').click(function() {
        $('#travel-form, #travel').toggle();
    });
});

function hasPreferences(obj) {
    for(var p in window.app.travels_preferences) {
        if(obj[p] == "1") {
            return true;
        }
    }
    return false;
}