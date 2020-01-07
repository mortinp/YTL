<?php App::uses('User', 'Model')?>
<?php App::uses('Travel', 'Model')?>

<?php
if (!isset($do_ajax))
    $do_ajax = false;

if(!isset ($intent)) $intent = 'register_and_create';
if (!isset($form_action)) {
    $form_action = 'register_and_create';
    $intent = 'register_and_create';
}

if (!isset($is_modal))
    $is_modal = false;

$origin = '';
$destination = '';
if(isset ($travel) && !empty ($travel)) {
    $saveButtonText = __d('pending_travel', 'Salvar Datos');
    
    $origin = $travel['Travel']['origin'];
    $destination = $travel['Travel']['destination'];
    
} else {
    $saveButtonText = __d('pending_travel', 'Crear Anuncio');
}
?>

<?php echo $this->Session->flash(); ?>
<?php echo $this->Form->create('Travel', array('default' => !$do_ajax, 'url' => array('controller' => 'users', 'action' => $form_action), 'id'=>'TravelForm'));?>
<input type="hidden" name="data[Travel][id]" class="form-control" value="" id="TravelId"/>
<div class="row row-sm-offset">
    <div class="col-md-6 multi-horizontal" data-for="name">
        <?php echo $this->Form->input('origin', array('type' => 'text', 'class'=>'locality-typeahead', 'label' => __d('pending_travel', 'Origen del Viaje').' <small class="text-muted">- '.__d('mobirise/pending_travel', 'ej. %s', 'La Habana, Varadero, Trinidad, Santiago de Cuba, etc.').'</small>', 'required'=>true, 'value'=>$origin/*, 'autofocus'=>'autofocus'*/));?>
    </div>
    <div class="col-md-6 multi-horizontal" data-for="email">
        <?php echo $this->Form->input('destination', array('type' => 'text', 'class'=>'locality-typeahead', 'label' => __d('pending_travel', 'Destino del Viaje').' <small class="text-muted">- '.__d('mobirise/pending_travel','ej. %s', __d('mobirise/pending_travel', 'Varios destinos, tu hotel en %s', 'Varadero').', Viñales, Cienfuegos, etc.').'</small>', 'required'=>true, 'value'=>$destination));?>
    </div>
</div>

<br>
<div class="row row-sm-offset">
    <div class="col-md-6 multi-horizontal" data-for="name">
        <?php echo $this->Form->custom_date('date', array('label' => __d('pending_travel', 'Fecha del Viaje'), 'dateFormat' => 'dd/mm/yyyy'));?>
    </div>
    <div class="col-md-6 multi-horizontal" data-for="email">
        <?php echo $this->Form->input('people_count', array('label' => __d('pending_travel', 'Personas que viajan <small class="text-info">(máximo número de personas)</small>'), 'default' => 1, 'min' => 1));?>
    </div>
</div>

<div class="form-group required">
    <label for="TravelDetails"><?php echo __d('pending_travel', 'Detalles del viaje')?></label>
    <textarea name="data[Travel][details]" class="form-control" placeholder="<?php echo __d('pending_travel', 'Cualquier detalle que quieras explicar')?>" cols="30" rows="6" id="TravelDetails" required="required"></textarea>
</div>

<div style="clear:both;overflow:auto;padding-bottom:20px">
    <div>
        <label><?php echo __d('pending_travel', 'Preferencias')?></label>
    </div>
    <div style="padding-right:10px;float:left">
        <input type="hidden" name="data[Travel][need_modern_car]" id="TravelNeedModernCar_" value="0"/>
        <input type="checkbox" name="data[Travel][need_modern_car]"  value="1" id="TravelNeedModernCar"/> <?php echo __d('pending_travel', 'Auto Moderno')?>
    </div>
    <div style="padding-right:10px;float:left">
        <input type="hidden" name="data[Travel][need_air_conditioner]" id="TravelNeedAirConditioner_" value="0"/>
        <input type="checkbox" name="data[Travel][need_air_conditioner]"  value="1" id="TravelNeedAirConditioner"/> <?php echo __d('pending_travel', 'Aire Acondicionado')?>
    </div>
</div>

<?php echo $this->Form->input('email', array('label' => __d('pending_travel', 'Tu correo electrónico'), 'type' => 'email', 'placeholder' => __d('pending_travel', 'Los choferes te contactarán a este correo')));?>

<br>
<div id="terms"><input type="checkbox" id="accept" name="accept"/> Acepta los <b><a style="color: blue" data-toggle="modal" data-target="#myModal4">Términos y Condiciones</a></b> para el uso de YoTeLlevoCuba.</div>
<span class="input-group-btn">
    <input type="submit" class="btn btn-primary btn-form display-5" id="TravelSubmit" 
           value="<?php echo __d('mobirise/homepage', 'Envía esta solicitud a varios choferes ahora')?>. <?php echo __d('mobirise/homepage', 'Recibe ofertas de ellos')?>"> 
        
</span>

<?php echo $this->Form->end(); ?>