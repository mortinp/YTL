<!-- Notificación a otros choferes-->
<?php
// CSS
$this->Html->css('bootstrap', array('inline' => false));
$this->Html->css('typeaheadjs-bootstrapcss/typeahead.js-bootstrap', array('inline' => false));

//JS
$this->Html->script('jquery', array('inline' => false));
$this->Html->script('bootstrap', array('inline' => false));
$this->Html->script('typeaheadjs/typeahead-martin', array('inline' => false));
$this->Html->script('bootbox/bootbox', array('inline' => false));

$this->Js->set('drivers_in', $drivers_in);

$this->Js->set('drivers', $drivers);
echo $this->Js->writeBuffer(array('inline' => false));

?>

<script type="text/javascript">
/**
 * Esta funcion hace que un formulario envie los datos por AJAX. Los datos se envian a la misma url definida en la propiedad 'action' del formulario.
 *
 * @param form: El formulario ej. $('#formulario')
 * @param obj:  Un objeto que contendría valores por defecto o preexistentes del modelo que se pretende crear o editar en el formulario.
 * Si el formulario tiene ya los valores, se puede pasar null.
 * @param onSuccess: una funcion que recibe el resultado del submit del formulario en un objeto que contiene los nuevos datos. Los nombres de los
 * campos en el objeto son los mismos nombres de los id de los campos del formulario.
 * @param onError: una funcion que recibe el jqXHR de la respuesta de error del submit del formulario
 **/
function _ajaxifyForm(form, obj, onSuccess, onError) {
    if(obj != null) setupFormForEdit(form, obj, alias);
    
    var btnSubmit = form.find('.submit').find('input');

    var doAjax = form.attr('onsubmit') != '' && form.attr('onsubmit') != null && form.attr('onsubmit') != undefined;// Esto es un hack, pero pincha bien!
    if(doAjax == true) {
        form.submit(function() {
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



$(document).ready(function() {
    
    $( ".open-modal" ).click(function( event ) {
    
        // Crear el bootbox
        bootbox.dialog({title:$(this).data('title'), message:$( '#' + $(this).data('modal') ).html(), onEscape: true});
        //bootbox.dialog({title:$(this).data('title'), message:'<form id="aaa" action="/yotellevo/en/travels/notify_driver_travel/221/M" onsubmit="event.returnValue = false; return false;"><input type="text"/><input type="submit" value="AAA" class="btn btn-info"></form>'});
        event.preventDefault();

        // Para cada formulario dentro del bootbox...
        var forms = $( '.bootbox form' );
        //var forms = $( '#aaa');
        $.each(forms, function(pos, obj) {
            var _form = $(obj);

            // ... convertir cada formulario en ajax
            _ajaxifyForm(_form, null,
                // onSuccess
                function(obj) {
                    window.app.drivers_in[window.app.notificationtravel].push(window.app.notifieddriver);
                    convLinkClass = 'text-muted';
                    if(obj.notification_type == 'R') convLinkClass = 'text-success';
                    var convLink = 
                        $('<a>')
                        .html(obj.conversation_id)
                        .attr('href', "<?php echo $this->Html->url(array('plugin'=>false, 'controller' => 'driver_traveler_conversations', 'action' => 'view', 'base'=>false), true)?>/" + obj.conversation_id)
                        .addClass(convLinkClass).addClass('info')
                        .attr('title', obj.driver_email)
                        .tooltip({placement: 'bottom', html:true});

                    var next = $('#conversations-travel-' + _form.data('travel-id') + ' .next-conversations');
                    next.append($('<li>').append(convLink));

                    _form.find('input.driver-typeahead').typeahead('setQuery', '').focus();

                    var messageDiv = _form.find('.ajax-msg');
                    messageDiv.empty().append($("<div class='text-success'>" + obj.driver_name + " fue notificado exitosamente...</div><br/>"));
                        setTimeout(function(){
                            messageDiv.empty();
                        }, 5000);
                    }, 

                // onError
                function(jqXHR) {
                    alert(jqXHR.responseText);
                }

            );
        });

        // Crear los typeahead
        $('input.driver-typeahead').typeahead({
            valueKey: 'driver_id',
            local: window.app.drivers,
            template: function(datum) {
                var display = datum.driver_id + ':';
                if(datum.driver_name != null) display += ' <b> ' + datum.driver_name + ' </b>';// Los espacios entre las <b> y el nombre son importantes para poder matchear por el nombre
                display += ' | ' + datum.driver_username;
                display += ' | ' + ' <b> ' + datum.province_name + ' </b>';// Los espacios entre las <b> y la provincia son importantes para poder matchear por la provincia
                display += ' | ' + datum.driver_pax + ' pax';

                return display;
            },
            limit: 50
        });
        $('input.tt-hint').addClass('form-control');
        $('.twitter-typeahead').css('display', 'block');

    });
    
});

</script>

<script type="text/javascript">
    function validar(travel_id, index){
        var driver_id = $(".bootbox-body").find("." + travel_id + "input" + index).val();
        if(driver_id == "") return true;
        var drivers_in = window.app.drivers_in;
        
        var i, result = true;
        for(i in drivers_in[travel_id]){
            if(driver_id == drivers_in[travel_id][i]){
                result = confirm('Este chofer ya fue notificado en este viaje. ¿Notificar de todas formas?');
                break;
            }    
        }
        window.app.notifieddriver     = driver_id;
        window.app.notificationtravel = travel_id;
        return result;
    }
</script>