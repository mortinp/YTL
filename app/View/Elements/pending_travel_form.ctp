<?php App::uses('User', 'Model')?>
<?php App::uses('Travel', 'Model')?>

<?php
if (!isset($do_ajax))
    $do_ajax = false;

if(!isset ($intent)) $intent = 'add_pending';
if (!isset($form_action)) {
    $form_action = 'add_pending';
    $intent = 'add_pending';
}

if (!isset($style))
    $style = '';
if (!isset($is_modal))
    $is_modal = false;

/*if (empty($this->request->data))
    $saveButtonText = 'Crear Anuncio';
else
    $saveButtonText = 'Salvar Datos';*/

if(!isset($horizontal)) $horizontal = false;

$origin = '';
$destination = '';
if(isset ($travel) && !empty ($travel)) {
    $saveButtonText = __d('pending_travel', 'Salvar Datos');
    
    $origin = $travel['PendingTravel']['origin'];
    $destination = $travel['PendingTravel']['destination'];
    
} else {
    $saveButtonText = __d('pending_travel', 'Crear Anuncio');
}

$buttonStyle = '';
if ($is_modal)
    $buttonStyle = 'display:inline-block;float:left';

$asLink = false;
if(isset ($bigButton) && $bigButton == true) {
    $saveButtonText = __d('pending_travel', "Pónme en contacto ahora <div style='font-size:12pt;padding-left:50px;padding-right:50px'>Contacta con <big>3</big> choferes. Escoge uno para tu viaje.</div>");
    $buttonStyle = 'font-size:18pt;white-space: normal;';
    $asLink = true;
}


$form_disabled = !User::canCreateTravel()/*AuthComponent::user('travel_count') > 0 && !AuthComponent::user('email_confirmed')*/;
?>

<?php if($intent === 'add' && $form_disabled):?>
    <div class="alert alert-warning">
        <b>Verifica tu cuenta de correo electrónico</b> para crear más anuncios de viajes. 
        El formulario de viajes permanecerá desactivado hasta que verifiques tu cuenta. 
        <div style="padding-top: 10px">
            <big><big><b><?php echo $this->Html->link('<i class="glyphicon glyphicon-ok"></i> Enviar correo de verificación', array('controller'=>'users', 'action'=>'send_confirm_email'), array('escape'=>false))?></b></big></big>
            <div><small>(Enviaremos un correo a <b><?php echo AuthComponent::user('username')?></b> con las instrucciones)</small></div>
        </div>        
    </div>
<?php else:?>
    <div>
        <div id='travel-ajax-message'></div>
        <div id="TravelFormDiv">
        <?php 
        echo $this->Form->create('PendingTravel', array('default' => !$do_ajax, 'url' => array('controller' => 'travels', 'action' => $form_action), 'style' => $style, 'id'=>'TravelForm'));?>
        <fieldset>
        <?php if(!$horizontal):?>
            <?php
            echo $this->Form->input('origin', array('type' => 'text', 'class'=>'locality-typeahead', 'label' => __d('pending_travel', 'Origen del Viaje'), 'required'=>true, 'value'=>$origin, 'autofocus'=>'autofocus'));
            echo $this->Form->input('destination', array('type' => 'text', 'class'=>'locality-typeahead', 'label' => __d('pending_travel', 'Destino del Viaje'), 'required'=>true, 'value'=>$destination));

            echo $this->Form->custom_date('date', array('label' => __d('pending_travel', 'Fecha del Viaje'), 'dateFormat' => 'dd/mm/yyyy'));
            echo $this->Form->input('people_count', array('label' => __d('pending_travel', 'Personas que viajan <small class="text-info">(máximo número de personas)</small>'), 'default' => 1, 'min' => 1));
            echo $this->Form->input('email', array('label' => __d('pending_travel', 'Tu correo electrónico'), 'type' => 'email', 'placeholder' => __d('pending_travel', 'Los choferes te contactarán a este correo')));
            echo $this->Form->input('details', array('label' => __d('pending_travel', 'Detalles del viaje'), 
                'placeholder' => __d('pending_travel', 'Cualquier detalle que quieras explicar')));
            echo $this->Form->checkbox_group(Travel::getPreferences(), array('header'=>__d('pending_travel', 'Preferencias')));
            echo $this->Form->input('id', array('type' => 'hidden'));
            
            $submitOptions = array('style' => $buttonStyle, 'id'=>'TravelSubmit', 'escape'=>false, 'rel'=>'nofollow');
            echo $this->Form->submit($saveButtonText, $submitOptions, $asLink);
            ?>
        <?php else:?>
            <div class="col-md-12">
                <div class="col-md-6">
                    <?php 
                    echo $this->Form->input('origin', array('type' => 'text', 'class'=>'locality-typeahead', 'label' => __d('pending_travel', 'Origen del Viaje'), 'required'=>true, 'value'=>$origin/*, 'autofocus'=>'autofocus'*/));
                    echo $this->Form->input('destination', array('type' => 'text', 'class'=>'locality-typeahead', 'label' => __d('pending_travel', 'Destino del Viaje'), 'required'=>true, 'value'=>$destination));
                    echo $this->Form->custom_date('date', array('label' => __d('pending_travel', 'Fecha del Viaje'), 'dateFormat' => 'dd/mm/yyyy'));
                    echo $this->Form->input('people_count', array('label' => __d('pending_travel', 'Personas que viajan <small class="text-info">(máximo número de personas)</small>'), 'default' => 1, 'min' => 1));
                    ?>
                </div>
                <div class="col-md-6">
                    <?php echo $this->Form->input('email', array('label' => __d('pending_travel', 'Tu correo electrónico'), 'type' => 'email', 'placeholder' => __d('pending_travel', 'Los choferes te contactarán a este correo')));?>
                    <div class="form-group required">
                        <label for="TravelDetails"><?php echo __d('pending_travel', 'Detalles del viaje')?></label>
                        <textarea name="data[PendingTravel][details]" class="form-control" placeholder="<?php echo __d('pending_travel', 'Cualquier detalle que quieras explicar')?>" cols="30" rows="6" id="TravelDetails" required="required"></textarea>
                    </div>
                    <div style="clear:both;height:100%;overflow:auto;padding-bottom:10px">
                        <div>
                            <label><?php echo __d('pending_travel', 'Preferencias')?></label>
                        </div>
                        <div style="padding-right:10px;float:left">
                            <input type="hidden" name="data[PendingTravel][need_modern_car]" id="TravelNeedModernCar_" value="0"/>
                            <input type="checkbox" name="data[PendingTravel][need_modern_car]"  value="1" id="TravelNeedModernCar"/> <?php echo __d('pending_travel', 'Auto Moderno')?>
                        </div>
                        <div style="padding-right:10px;float:left">
                            <input type="hidden" name="data[PendingTravel][need_air_conditioner]" id="TravelNeedAirConditioner_" value="0"/>
                            <input type="checkbox" name="data[PendingTravel][need_air_conditioner]"  value="1" id="TravelNeedAirConditioner"/> <?php echo __d('pending_travel', 'Aire Acondicionado')?>
                        </div>
                    </div>
                    <input type="hidden" name="data[PendingTravel][id]" class="form-control" value="" id="TravelId"/>
                </div>	
            </div>
            <div class="submit col-md-6 col-md-offset-3" style="text-align: center">
                <?php $submitOptions = array('style' => $buttonStyle, 'id'=>'TravelSubmit', 'escape'=>false, 'rel'=>'nofollow');
                echo $this->Form->submit($saveButtonText, $submitOptions, $asLink);?>
            </div>
            
            
        <?php endif?>        
        </fieldset>
        <?php echo $this->Form->end(); ?>
        </div>
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
$this->Html->script('jquery-validation-1.10.0/localization/messages_'.Configure::read('Config.language'), array('inline' => false));

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
                $('#TravelSubmit').val('<?php echo __d('pending_travel', 'Espera')?> ...');
            })
        <?php endif?>
    })
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('input.locality-typeahead').typeahead({
            valueKey: 'name',
            local: window.app.localities
        })/*.on('typeahead:selected', function(event, datum) {
            
        })*/;
        
        $('input.tt-hint').addClass('form-control');
        $('.twitter-typeahead').css('display', 'block');
    });

</script>

<script type="text/javascript">
    //<![CDATA[
    function get_form( element )
    {
        while( element )
        {
            element = element.parentNode
            if( element.tagName.toLowerCase() == "form" ) {
                return element
            }
        }
        return 0; //error: no form found in ancestors
    }
    //]]>
</script>