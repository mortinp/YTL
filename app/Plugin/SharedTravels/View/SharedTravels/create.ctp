<?php $modality = SharedTravel::$modalities[$this->request->query['s']]?>
<div id="request-ride" data-h-offset="0" class="row arrow_box arrow_box_bottom"></div>
<div class="row" style="background-color: #ebebeb;padding-bottom: 20px">
    <div class="row" style="padding-top: 80px;">
        <div class="col-md-10 col-md-offset-1" style="text-align: center">
            <p class="lead">
                <?php echo __d('shared_travels', 'Solicita un transfer de %s a %s por un precio de %s por persona', 
                        '<code><big>'.$modality['origin'].'</big></code>', 
                        '<code><big>'.$modality['destination'].'</big></code>', 
                        '<code><big><big>'.$modality['price'].' CUC'.'</big></big></code>')?>
            </p>
            <p class="lead">
                <?php echo __d('shared_travels', 'Recogida a las %s en el lugar y fecha que indiques','<code><big>'.$modality['time'].'</big></code>')?>
            </p>
        </div>
    </div>
    <div class="row" style="margin-top: 40px;">
        
        <div class="col-md-6 col-md-offset-1">
            <?php echo $this->element('shared_travel_form')?>
        </div>
        <div class="col-md-3 col-md-offset-1 alert alert-warning" style="display: inline-block">
            <p style="text-align: center"><b><?php echo __d('shared_travels', 'TÉRMINOS DEL SERVICIO')?></b></p><hr/>
            <ul>
               <li><?php echo __d('shared_travels', 'Servicio <b>compartido</b> en <b>auto moderno</b> de <b>4 plazas</b> con <b>aire acondicionado</b> y excelente confort.')?></li>
               <br/>
               <li><?php echo __d('shared_travels', 'Servicio <b>puerta a puerta</b> (recogida en casa u hotel y se deja en casa u hotel del destino).')?></li>
               <br/>
               <li><?php echo __d('shared_travels', 'La <b>recogida puede demorar hasta 30 minutos</b> después de la hora establecida para el servicio, pues el chofer planifica su recorrido para recoger a los 4 viajeros.')?></li>
               <br/>
               <li><?php echo __d('shared_travels', 'El <b>pago es en efectivo y en CUC</b> directamente al chofer al efectuarse la recogida.')?></li>
            </ul>
        </div>
    </div>
</div>


<script type="text/javascript">
$(document).ready(function() {
    $('.goto').click(function() {
        goTo( $(this).data('go-to') ); 
    });
    
});

function goTo(id) {
    $('html, body').animate({
        scrollTop: $('#' + id).offset().top
    }, 300);
};
</script>