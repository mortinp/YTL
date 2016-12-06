<div class="row" style="margin-bottom: 25px">
    <div class="col-md-6 col-md-offset-3 h4 arrow_box arrow_box_bottom" style="border: 2px solid #cccccc; padding: 25px">
        <p><?php echo __d('testimonials', 'Muchas gracias por decidir dejar una opinión sobre tu viaje con tu chofer en Cuba. Esperamos que la hayas pasado genial')?> !</p>
        <p><?php echo __d('testimonials', 'El chofer debe haberte dado su <code>código personal</code> que te permite poner un comentario sobre él o ella aquí en nuestro sitio.').' '.__d('testimonials', 'Úsalo debajo')?>:</p>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <?php echo $this->Form->create('Testimonial', array('url'=>array('action'=>'enter_code'), 'id'=>'EnterCodeForm')); ?>
        <fieldset>
            <?php
            echo $this->Form->input('driver_code', array('label' => __d('testimonials', 'Escribe el <code>código personal del chofer</code> aquí').':', 'autofocus'=>true, 'escape'=>false, 'required'=>'required', 'style'=>'text-transform:uppercase'));
            
            $buttonText = __d('testimonials', 'Enviar código del chofer').' »<div style="font-size:12pt;padding-left:50px;padding-right:50px">'.__d('testimonials', 'Enseguida podrás opinar sobre su servicio').'</div>';
            echo $this->Form->submit($buttonText, array('id'=>'EnterCodeSubmit', 'class'=>'btn btn-block btn-warning', 'style'=>'font-size:18pt;white-space: normal;', 'escape'=>false, 'rel'=>'nofollow'), true);
            ?>
        </fieldset>
        <?php echo $this->Form->end(); ?>
    </div>
</div>

<?php echo $this->element('addon_scripts_send_form', array('formId'=>'EnterCodeForm', 'submitId'=>'EnterCodeSubmit'))?>