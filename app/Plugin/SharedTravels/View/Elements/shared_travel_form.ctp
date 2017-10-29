<?php App::uses('SharedTravel', 'SharedTravels.Model')?>

<?php
$modalityCode = $this->request->query['s'];
$modality = SharedTravel::$modalities[$modalityCode];
?>

<?php
$emailValue = null;
$peopleCountValue = 1;
$nameIdValue = null;
if($this->Session->read('SharedTravels.email')) $emailValue = $this->Session->read('SharedTravels.email');
else if($userLoggedIn) $emailValue = AuthComponent::user('username');
if($this->Session->read('SharedTravels.people_count')) $peopleCountValue = $this->Session->read('SharedTravels.people_count');
if($this->Session->read('SharedTravels.name_id')) $nameIdValue = $this->Session->read('SharedTravels.name_id');
?>

<div>
    <?php 
    echo $this->Form->create('SharedTravel', array('url' => array('controller' => 'shared_travels', 'action' => 'create'), 'id'=>'SharedTravelForm'));?>
    <fieldset>
        <div class="row">
            
            <div class="col-md-6">
                <p><b><?php echo __d('shared_travels', 'DATOS DEL TRANSFER')?></b></p><hr/>
                <?php echo $this->Form->input('modality_code', array('type' => 'hidden', 'value'=>$modalityCode));?>
                
                <?php echo $this->Form->custom_date('date', array('label' => __d('shared_travels', 'Fecha en que necesitas el servicio'), 'dateFormat' => 'dd/mm/yyyy'));?>
                <?php echo $this->Form->input('people_count', array('label' => __d('shared_travels', 'Cantidad de personas'), 'value'=>$peopleCountValue, 'default' => 1, 'min' => 1, 'max' => 4));?>
                <div class="form-group required">
                    <label for="AddressOrigin"><?php echo __d('shared_travels', 'Dirección de recogida en %s', '<code><big>'.$modality['origin'].'</big></code>')?></label>
                    <textarea name="data[SharedTravel][address_origin]" class="form-control" placeholder="<?php echo __d('shared_travels', 'Dirección exacta de la casa o nombre del hotel donde debemos recogerle')?>" rows="3" id="AddressOrigin" required="required"></textarea>
                </div>
                <div class="form-group required">
                    <label for="AddressDestination"><?php echo __d('shared_travels', 'Dirección de destino en %s', '<code><big>'.$modality['destination'].'</big></code>')?></label>
                    <textarea name="data[SharedTravel][address_destination]" class="form-control" placeholder="<?php echo __d('shared_travels', 'Dirección de la casa o nombre del hotel')?>" rows="3" id="AddressDestination" required="required"></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <p><b><?php echo __d('shared_travels', 'DATOS DE CONTACTO')?></b></p><hr/>
                <?php echo $this->Form->input('email', array('label' => __d('shared_travels', 'Tu correo electrónico'), 'value'=>$emailValue, 'type' => 'email', 'required'=>'required'));?>
                <?php echo $this->Form->input('name_id', array('label' => __d('shared_travels', 'Tu nombre completo para fácil identificación'),'value'=>$nameIdValue, 'type' => 'text', 'required'=>'required'));?>
                <!--<div class="form-group">
                    <label for="Contacts"><?php echo __d('shared_travels', 'Teléfono de contacto (ej. teléfono de la casa u hotel en Cuba)')?></label>
                    <textarea name="data[SharedTravel][contacts]" class="form-control" placeholder="<?php echo __d('shared_travels', 'Teléfono para rápìda comunicación en caso necesario')?>" rows="2" id="Contacts"></textarea>
                </div>-->
            </div>
            
        </div>
        
        <br/>
        <div class="row">
            <div class="submit col-md-12" style="text-align: center">
                <?php 
                $submitOptions = array('class'=>'btn btn-block btn-warning', 'style' => 'font-size:14pt;white-space: normal;', 'id'=>'SharedTravelSubmit', 'escape'=>false, 'rel'=>'nofollow');
                echo $this->Form->submit(__d('shared_travels', 'Solicitar este transfer %s - %s', $modality['origin'], $modality['destination']), $submitOptions);
                ?>
            </div> 
        </div>
    </fieldset>
    <?php echo $this->Form->end(); ?>
</div>


<?php
// CSS
$this->Html->css('bootstrap', array('inline' => false));
$this->Html->css('vitalets-bootstrap-datepicker/datepicker.min', array('inline' => false));

//JS
$this->Html->script('jquery', array('inline' => false));
$this->Html->script('bootstrap', array('inline' => false));

$this->Html->script('vitalets-bootstrap-datepicker/bootstrap-datepicker.min', array('inline' => false));

$this->Html->script('jquery-validation-1.10.0/dist/jquery.validate.min', array('inline' => false));
$this->Html->script('jquery-validation-1.10.0/localization/messages_'.Configure::read('Config.language'), array('inline' => false));

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
        
        $('#SharedTravelForm').validate({
            wrapper: 'div',
            errorClass: 'text-danger',
            errorElement: 'div'
        });
       
       $('#SharedTravelForm').submit(function() {
            if (!$(this).valid()) return false;

            //$('#TravelForm :input').prop('disabled', true);
            //$('#TravelFormDiv').prop('disabled', true);

            $('#SharedTravelSubmit').attr('disabled', true);
            $('#SharedTravelSubmit').val('<?php echo __('Espera')?> ...');
        });
    })
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