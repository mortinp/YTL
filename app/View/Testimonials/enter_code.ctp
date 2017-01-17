<div class="row" style="margin-bottom: 25px">
    <div class="col-md-6 col-md-offset-3 h4 arrow_box arrow_box_bottom" style="border: 2px solid #cccccc; padding: 25px">
        <p><?php echo __d('testimonials', 'Muchas gracias por decidir dejar una opinión sobre tu viaje con tu chofer en Cuba. Esperamos que la hayas pasado genial')?> !</p>
        <p><?php echo __d('testimonials', 'El chofer debe haberte dado su <code>código personal</code> que te permite poner un comentario sobre él o ella aquí en nuestro sitio.').' '.__d('testimonials', 'Úsalo debajo')?>:</p>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <?php echo $this->element('form_testimonial_enter_driver_code')?>
    </div>
</div>

<?php echo $this->element('addon_scripts_send_form', array('formId'=>'EnterCodeForm', 'submitId'=>'EnterCodeSubmit'))?>