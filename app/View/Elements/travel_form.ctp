<?php App::uses('User', 'Model')?>

<?php
if (!isset($do_ajax))
    $do_ajax = false;

if(!isset ($intent)) $intent = 'add';
if (!isset($form_action)) {
    $form_action = 'add';
    $intent = 'add';
}

if (!isset($style))
    $style = '';
if (!isset($is_modal))
    $is_modal = false;

$buttonStyle = '';
if ($is_modal)
    $buttonStyle = 'display:inline-block;float:left';

/*if (empty($this->request->data))
    $saveButtonText = 'Crear Anuncio';
else
    $saveButtonText = 'Salvar Datos';*/

$origin = '';
$destination = '';
if(isset ($travel) && !empty ($travel)) {
    $saveButtonText = __('Salvar Datos');
    
    $origin = $travel['Travel']['origin'];
    $destination = $travel['Travel']['destination'];
    
} else {
    $saveButtonText = __('Crear Anuncio');
}

$form_disabled = !User::canCreateTravel()/*AuthComponent::user('travel_count') > 0 && !AuthComponent::user('email_confirmed')*/;
?>

<?php if($intent === 'add' && $form_disabled):?>
    <div class="alert alert-warning">
        <?php echo __('<b>Verifica tu cuenta de correo electrónico</b> para crear más anuncios de viajes. 
        El formulario de viajes permanecerá desactivado hasta que verifiques tu cuenta')?>. 
        <div style="padding-top: 10px">
            <big><big><b><?php echo $this->Html->link('<i class="glyphicon glyphicon-ok"></i> '.__('Enviar correo de verificación'), array('controller'=>'users', 'action'=>'send_confirm_email'), array('escape'=>false))?></b></big></big>
            <div><small>(<?php echo __('Enviaremos un correo a')?> <b><?php echo AuthComponent::user('username')?></b> <?php echo __('con las instrucciones')?>)</small></div>
        </div>        
    </div>
<?php else:?>
    <div>
        <div id='travel-ajax-message'></div>
        <div id="TravelFormDiv">
        <?php echo $this->Form->create('Travel', array('default' => !$do_ajax, 'url' => array('controller' => 'travels', 'action' => $form_action), 'style' => $style, 'id'=>'TravelForm'));?>
        <fieldset>
            <?php
            echo $this->Form->input('origin', array('type' => 'text', 'class'=>'locality-typeahead', 'label' => __('Origen del Viaje'), 'required'=>true, 'value'=>$origin, 'autofocus'=>'autofocus'));
            echo $this->Form->input('destination', array('type' => 'text', 'class'=>'locality-typeahead', 'label' => __('Destino del Viaje'), 'required'=>true, 'value'=>$destination));
            echo $this->Form->custom_date('date', array('label' => __('Cuándo'), 'dateFormat' => 'dd/mm/yyyy'));
            echo $this->Form->input('people_count', array('label' => __('Personas que viajan <small class="text-info">(máximo número de personas)</small>'), 'default' => 1, 'min' => 1));
            echo $this->Form->input('details', array('label' => __('Detalles del viaje'), 
                'placeholder' => __('Cualquier detalle que quieras explicar')));
            echo $this->Form->checkbox_group(Travel::$preferences, array('header'=>__('Preferencias')));
            echo $this->Form->input('id', array('type' => 'hidden'));

            $submitOptions = array('style' => $buttonStyle, 'id'=>'TravelSubmit');
            //if(!$do_ajax) $submitOptions['onclick'] = 'this.value="Espere ...";this.disabled=true;this.form.disabled=true;this.form.submit();';
            echo $this->Form->submit(__($saveButtonText), $submitOptions);
            if ($is_modal)
                echo $this->Form->button(__('Cancelar'), array('id' => 'btn-cancel-travel', 'style' => 'display:inline-block'));
            ?>
        </fieldset>
        <?php echo $this->Form->end(); ?>
        </div>
        <!--<?php if($intent == 'add'):?>
            <br/>
            <div class="alert alert-warning">
                <?php echo __('La <b>Información de Contacto</b> es importante para que los choferes lleguen a tí. Asegúrate de que esta información sea correcta.')?>
            </div>
        <?php endif?>-->
    </div>
<?php endif?>


<?php
// CSS
$this->Html->css('bootstrap', array('inline' => false));
$this->Html->css('vitalets-bootstrap-datepicker/datepicker.min', array('inline' => false));
$this->Html->css('typeaheadjs-bootstrapcss/typeahead.js-bootstrap', array('inline' => false));

//JS
$this->Html->script('jquery', array('inline' => false));
$this->Html->script('bootstrap', array('inline' => false));

$this->Html->script('vitalets-bootstrap-datepicker/bootstrap-datepicker.min', array('inline' => false));

$this->Html->script('jquery-validation-1.10.0/dist/jquery.validate.min', array('inline' => false));
$this->Html->script('jquery-validation-1.10.0/localization/messages_es', array('inline' => false));

$this->Html->script('typeaheadjs/typeahead-martin', array('inline' => false));


$this->Js->set('localities', $localities);
echo $this->Js->writeBuffer(array('inline' => false));

?>

<script type="text/javascript">    
    $(document).ready(function() {        
        $('.datepicker').datepicker({
            format: "dd/mm/yyyy",
            language: '<?php echo Configure::read('Config.language')?>',
            startDate: 'today',
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        });
        
        $('#TravelForm').validate({
            wrapper: 'div',
            errorClass: 'text-danger',
            errorElement: 'div'
        });  
        
        <?php if(!$do_ajax):?>
            $('#TravelForm').submit(function() {
                if (!$(this).valid()) return false;
                
                //$('#TravelForm :input').prop('disabled', true);
                //$('#TravelFormDiv').prop('disabled', true);
                
                $('#TravelSubmit').attr('disabled', true);
                $('#TravelSubmit').val('<?php echo __('Espera')?> ...');
            })
        <?php endif?>
    })
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('input.locality-typeahead').typeahead({
            //name: 'localities',
            //header: '<b>Localidades</b>',
            valueKey: 'name',
            local: window.app.localities
        }).on('typeahead:selected', function(event, datum) {
            /*if($(event.target).attr('id') == 'TravelOrigin') {
                $('#TravelForm').find('#TravelOriginId').remove();
                $('#TravelForm').append('<input type="hidden" id="TravelOriginId" name="data[Travel][origin_id]" value="' + datum.id + '">');
            } else if($(event.target).attr('id') == 'TravelDestination') {
                $('#TravelForm').find('#TravelDestinationId').remove();
                $('#TravelForm').append('<input type="hidden" id="TravelDestinationId" name="data[Travel][destination_id]" value="' + datum.id + '">');
            }*/
        });
        
        $('input.tt-hint').addClass('form-control');
        $('.twitter-typeahead').css('display', 'block');
    });
    
    /*var substringMatcher = function(strs) {
        return function findMatches(q, cb) {
            var matches, substringRegex;

            // an array that will be populated with substring matches
            matches = [];

            // regex used to determine if a string contains the substring `q`
            substrRegex = new RegExp(q, 'i');

            // iterate through the pool of strings and for any string that
            // contains the substring `q`, add it to the `matches` array
            $.each(strs, function(i, str) {
                if (substrRegex.test(str)) {
                    // the typeahead jQuery plugin expects suggestions to a
                    // JavaScript object, refer to typeahead docs for more info
                    matches.push({ value: str });
                }
            });

            cb(matches);
        };
    };*/

</script>