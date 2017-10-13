<?php $modality = SharedTravel::$modalities[$this->request->query['s']]?>

<?php     
    $other = array('en' => 'es', 'es' => 'en');
    $lang = $this->Session->read('Config.language');

    $lang_changed_url             = $this->request['pass'];
    $lang_changed_url             = array_merge($lang_changed_url, $this->request['named']);
    $lang_changed_url['?']        = $this->request->query;
    $lang_changed_url['language'] = $other[$lang];
?>

<div class="container">
    <div class="row" style="margin-top: 40px">
        <div class="col-md-10 col-md-offset-1">
            <br/>
            <p class="text-muted" style="text-align: center"><?php echo __d('shared_travels', '¿Necesitas ir desde %s hasta %s durante tu viaje a Cuba?', '<code><big><big>'.$modality['origin'].'</big></big></code>', '<code><big><big>'.$modality['destination'].'</big></big></code>') ?></p>
            <h1 style="text-align: center">
                <?php echo __d('shared_travels', 'Comparte un auto cómodo con otros viajeros.') ?> <?php echo __d('shared_travels', 'Haz tu viaje por un precio muy conveniente.') ?>
            </h1> 
            <br/>
            <h4 style="text-align: center"><?php echo __d('shared_travels', 'Autos modernos de 4 plazas. Aire acondicionado. Servicio puerta a puerta.') ?></h4>
            
            <hr/>
        </div>
    </div>
    
    <div class="row" style="margin-top: 50px;text-align: center">
        <h3><?php echo __d('shared_travels', '¿Cómo funciona?')?></h3>
    
        <br/>
        <div class="col-md-2 center col-md-offset-2">
            <?php echo __d('shared_travels', 'Solicitas el servicio y nos dices cuándo y dónde recogerte en %s.', $modality['origin'])?>
        </div>
        <div class="col-md-2 center">
            <?php echo __d('shared_travels', 'Enseguida hacemos todos los arreglos y te confirmamos en menos de 24 horas.')?>
        </div>
        <div class="col-md-2 center">
            <?php echo __d('shared_travels', 'Te asignamos un operador con quien mantendrás comunicación todo el tiempo.')?>
        </div>
        <div class="col-md-2 center">
            <?php echo __d('shared_travels', 'Cuando llega la fecha, enviamos el auto a recogerte y haces tu viaje hasta %s.', $modality['destination'])?>
        </div>
        
    </div>
    
</div>

<div id="request-ride" data-h-offset="0" class="row arrow_box arrow_box_bottom" style="margin-top: 80px"></div>
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
        
        <!--<div class="col-md-10 col-md-offset-1 center">
            <span class="alert alert-danger" style="display: inline-block"><?php echo __d('shared_travels', 'Considera NO solicitar este servicio si llevas mucho equipaje. El espacio del auto es compartido y queremos que todos viajen cómodos.')?></span>
        </div>-->
        
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