
<div id="popup-actions" style="display: none">    
    <div><?php echo __d('driver_profile', 'Estas son un par de cosas que puedes hacer en el perfil de %s', $driver_short_name)?>:</div>
    <br/>
    
    <div>
        <ul style="list-style-type:none">
            <li style="padding-bottom: 10px" class="bg-info">
                <div style="padding: 10px"><?php echo __d('driver_profile', 'Enviar un mensaje a %s para arreglar un viaje con él', $driver_short_name)?>:</div>
                <div><a href="#!" class="btn btn-block btn-info goto" data-go-to="message-driver"><?php echo __d('driver_profile', 'Sí, quiero enviar un mensaje a %s', $driver_short_name)?></a></div>
            </li>
            <hr/>
            
            <li style="padding-bottom: 10px" class="bg-warning">
                <div style="padding: 10px"><?php echo __d('driver_profile', 'Si ya usaste sus servicios, puedes escribir una opinión sobre él', $driver_short_name)?>:</div>
                <div><?php echo $this->Html->link(__d('driver_profile', 'Sí, quiero escribir una opinión sobre %s', $driver_short_name), array('controller'=>'testimonials', 'action'=>'enter_code'), array('class'=>'btn btn-block btn-warning'))?>
            </li>
        </ul>
        
        <br/>
        <div class="alert alert-warning" style="display: inline-block"><?php echo __d('driver_profile', 'Una vez que cierres esta ventana, puedes acceder a ambas opciones desde el menú de arriba.', $driver_short_name)?></div>
    </div>
</div>

<?php
// CSS
$this->Html->css('bootstrap', array('inline' => false));
//JS
$this->Html->script('jquery', array('inline' => false));
$this->Html->script('bootstrap', array('inline' => false));
$this->Html->script('bootbox/bootbox', array('inline' => false));

echo $this->Js->writeBuffer(array('inline' => false));
?>
    
<script type="text/javascript">
$(document).ready(function() {  
    setTimeout(function() {
        var dialog = bootbox.alert({
            title:"<?php echo __d('driver_profile', 'Lo sentimos por interrumpirte aquí')?>...", 
            message:$( '#popup-actions').html(), 
            onEscape: true,
            buttons: {
                ok: {
                    label: '<?php echo __d('driver_profile', 'Entendido')?>!',
                    className: 'btn-block btn-primary'
                }
            }
        });

        $('.goto').click(function() {
            dialog.modal('hide');
            goTo( $(this).data('go-to') );
        });

    }, 20000);  
});

function goTo(id) {
    $('html, body').animate({
        scrollTop: $('#' + id).offset().top
    }, 300);
};
</script>

