<?php if(!isset ($autofocus)) $autofocus = true; ?>
<?php echo $this->Form->create('Testimonial', array('url'=>array('action'=>'enter_code'), 'id'=>'EnterCodeForm')); ?>
<fieldset>
    <?php
    echo $this->Form->input('driver_code', array('label' => __d('testimonials', 'Escribe el <code>código personal del chofer</code> aquí').':', 'autofocus'=>$autofocus, 'escape'=>false, 'required'=>'required', 'style'=>'text-transform:uppercase'));

    $buttonText = __d('testimonials', 'Enviar código del chofer').' »<div style="font-size:12pt;padding-left:50px;padding-right:50px">'.__d('testimonials', 'Enseguida podrás opinar sobre su servicio').'</div>';
    echo $this->Form->submit($buttonText, array('id'=>'EnterCodeSubmit', 'class'=>'btn btn-block btn-warning', 'style'=>'font-size:18pt;white-space: normal;', 'escape'=>false, 'rel'=>'nofollow'), true);
    ?>
</fieldset>
<?php echo $this->Form->end(); ?>