<?php $isLoggedIn = AuthComponent::user('id') ? true : false;?>

<?php
echo $this->Form->create('Contact', array('url' => array('controller' => 'contacts', 'action' => 'contact')));
?>
<fieldset>
    <?php
    echo $this->Form->input('name', array('type' => 'text', 'label' => __('Nombre'), 'placeholder' => __('Tu nombre'), 'required'=>true));
    if(!$isLoggedIn) echo $this->Form->input('email', array('type' => 'email', 'label' => __('Correo electrónico') , 'placeholder' => __('Tu correo para contactarte')));
    echo $this->Form->input('text', array('type'=>'textarea', 'label' => __('Texto'), 'placeholder'=>__('Lo que quieras decirnos, escríbelo aquí'), 'required'=>true));
    
    if($isLoggedIn) echo '<div class="text-info" style="padding-bottom:20px">'.__('Estás contactándonos a nombre de').'<b> '.AuthComponent::user('username').'</b></div>';
    echo $this->Form->submit(__('Enviar'));        
    ?>
</fieldset>
<?php echo $this->Form->end(); ?>