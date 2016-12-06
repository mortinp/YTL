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
    <?php echo $this->Form->create('DriverProfile', array('type'=>'file')); ?>
    <fieldset>
        <?php
        echo $this->Form->input('id', array('type'=>'hidden'));
        echo $this->Form->input('driver_nick', array('type'=>'text', 'label'=>'Nick (todo con minúscula, ej. martin-proenza-grm)'));  
        echo $this->Form->input('driver_name', array('type'=>'text', 'label'=>'Nombre'));
        echo $this->Form->input('driver_code', array('type'=>'text', 'label'=>'Código del chofer (max. 10 caracteres)', 'style'=>'text-transform:uppercase'));
        
        echo $this->Form->label('avatar');
        if(isset($this->request->data['DriverProfile'])) {
            $src = '';
            if(Configure::read('debug') > 0) $src .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien
            $src .= '/'.str_replace('\\', '/', $this->request->data['DriverProfile']['avatar_filepath']);
            echo '<img src="'.$src.'"/>';
        }
        echo $this->Form->file('avatar', array('label'=>'Avatar'));
        echo '<br/>';
        
        echo $this->Form->input('description_es', array('label'=>'Descripción Español'));
        echo $this->Form->input('description_en', array('label'=>'Description English'));
        echo $this->Form->checkbox('show_profile').' Mostrar Perfil';
        //echo $this->Form->file('resources', array('multiple'=>3));
        ?>
        <br/>
        <br/>
        <?php
        echo $this->Form->submit($saveButtonText);
        if ($is_modal)
            echo $this->Form->button('Cancelar', array('id' => 'btn-cancel-driver', 'style' => 'display:inline-block'));
        ?>
    </fieldset>
    <?php echo $this->Form->end(); ?>
</div>