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
    <?php echo $this->Form->create('Locality'); ?>
    <fieldset>
        <?php
        echo $this->Form->input('id', array('type'=>'hidden'));
        echo $this->Form->input('name', array('type'=>'text'));  
        echo $this->Form->input('province_id', array('type' => 'select', 'options' => $provinces, 'label' => 'Provincia'));
        echo $this->Form->submit($saveButtonText);
        if ($is_modal)
            echo $this->Form->button('Cancelar', array('id' => 'btn-cancel-driver', 'style' => 'display:inline-block'));
        ?>
    </fieldset>
    <?php echo $this->Form->end(); ?>
</div>