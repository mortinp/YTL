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

if (empty($this->request->data))
    $saveButtonText = 'Crear';
else
    $saveButtonText = 'Salvar';

?>

<div>
    <?php echo $this->Form->create('Driver'); ?>
    <fieldset>
        <?php
        echo $this->Form->input('id', array('type'=>'hidden'));
        echo $this->Form->input('username', array('type'=>'text'));
        if($form_action == 'add') echo $this->Form->input('password');
        else 
            echo $this->Form->input('password', array('label'=>'Contraseña', 'placeholder'=>'Contraseña vacía significa que no quieres cambiarla', 'required'=>false));
        
        echo $this->Form->input('max_people_count');
        echo $this->Form->checkbox_group(array('has_modern_car'=>'Carro Moderno', 'has_air_conditioner'=>'Aire Acondicionado'), array('header'=>'Características'));
        echo $this->Form->input('description');
        
        //if($form_action == 'add') 
            echo $this->Form->input('Locality', array('id'=>'LocalitiesSelect', 'type' => 'select', 'multiple'=>'multiple', /*'options' => $localities,*/ 'showParents' => true, 
                'label' => __('Localidades <small class="text-info">(seleccionar con <b>Ctrl + Click</b>)</small>')));
        
        echo $this->Form->checkbox('active').' Active';
        
        echo $this->Form->submit($saveButtonText);
        if ($is_modal)
            echo $this->Form->button(__('Cancelar'), array('id' => 'btn-cancel-driver', 'style' => 'display:inline-block'));
        ?>
    </fieldset>
    <?php echo $this->Form->end(); ?>
</div>

<?php
/*// CSS
//$this->Html->css('bootstrap', array('inline' => false));
$this->Html->css('select2/select2', array('inline' => false));

// JS
$this->Html->script('jquery', array('inline' => false));
$this->Html->script('select2/select2', array('inline' => false));*/
?>

<!--<script type="text/javascript">
    $(document).ready(function() {
        $('#LocalitiesSelect').select2();
    });
</script>-->