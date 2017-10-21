<div class="container">
    <div class="row" style="margin-top: 40px">
        <div class="col-md-10 col-md-offset-1">
            <br/>
            <p class="text-muted" style="text-align: center"><?php echo __d('shared_travels', '¿Necesitas ir <code><big>desde un destino a otro</big></code> durante tu viaje a <code><big><big>Cuba</big></big></code>?') ?></p>
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
        <div class="col-md-2 center col-md-offset-2 col-sm-6" style="padding-bottom: 30px">
            <?php echo __d('shared_travels', 'Solicitas el servicio para algunas de nuestras rutas y horarios. Nos dices cuándo necesitas el servicio, dónde recogerte y cuántas personas son.')?>
        </div>
        <div class="col-md-2 center col-sm-6" style="padding-bottom: 30px">
            <?php echo __d('shared_travels', 'Enseguida hacemos todos los arreglos y te confirmamos el viaje en cuanto tengamos otras solicitudes que llenen las 4 plazas de un auto.')?>
        </div>
        <div class="col-md-2 center col-sm-6" style="padding-bottom: 30px">
            <?php echo __d('shared_travels', 'Mientras llega la fecha del viaje te asignamos un operador asistente con quien mantendrás comunicación todo el tiempo.')?>
        </div>
        <div class="col-md-2 center col-sm-6" style="padding-bottom: 30px">
            <?php echo __d('shared_travels', 'Llegada la fecha enviamos el auto con chofer a recogerte al lugar donde indiques y en el horario pactado para realizar el viaje.')?>
        </div>
        
    </div>
    
</div>

<div id="transfers-available" data-h-offset="0" class="row arrow_box arrow_box_bottom" style="margin-top: 60px"></div>
<div class="row" style="background-color: #ebebeb;padding-bottom: 80px">
    <div class="container">
        <div class="row" style="padding-top: 80px;">
            <div class="col-md-10 col-md-offset-1" style="text-align: center">
                <p class="lead">
                    <?php echo __d('shared_travels', 'Selecciona una de nuestras rutas y horarios para reservar un transfer')?>
                </p>
                <p>
                    <big><?php echo __d('shared_travels', 'Uno de nuestros choferes te recogerá en el lugar y fecha que indiques')?></big>
                </p>
            </div>        
        </div>
            
        <?php foreach (SharedTravel::$localities as $locality_id => $locality):?>
            <div class="row" style="margin-top: 40px;">
            <div><big><?php echo __d('shared_travels', 'Transfers disponibles desde %s', '<b><code><big><big>'.$locality.'</big></big></code></b>')?></big></div>
            <br/>
            <?php $i=0?>
            <?php foreach (SharedTravel::$modalities as $code=>$modality):?>
                <?php if($modality['origin_id'] == $locality_id):?>
                    <div class="col-md-3 col-sm-6" style="padding: 20px"><?php echo $this->element('modality_info', compact('modality') + compact('code'))?></div>
                    <?php $i++?>
                    <?php if($i == 4):?><?php $i = 0?><br/><br/><?php endif?>
                <?php endif?>
            <?php endforeach?>
            </div>
            
            <br/>
            <hr/>
        <?php endforeach?>
        
    </div>
</div>
<div class="row arrow_box arrow_box_top" style=""></div>

<div class="row" style="padding-top: 80px">
    <div class="container">
        <div class="col-md-8 col-md-offset-2">
            <p class="lead"><big><?php echo __d('shared_travels', 'Preguntas frecuentes')?></big></p>
            <hr/>
            <p class="lead">1. <?php echo __d('shared_travels', '¿Cuánto demoran en confirmarme la realización del viaje?')?></p>
            <p><?php echo __d('shared_travels', 'Usualmente confirmamos instantáneamente porque tenemos otras solicitudes pendientes que se pueden emparejar en el mismo viaje con usted.')?></p>
            <p><?php echo __d('shared_travels', 'Cuando esto no ocurre entonces usamos otras vías para recibir solicitudes, por lo cual lo normal es que confirmemos  en las primeras 24 horas.')?></p>
            <p><?php echo __d('shared_travels', 'Una vez que le confirmamos, ya su viaje queda en nuestra agenda y el viaje se realizará sin problemas.')?></p>
            <br/>
            <p class="lead">2. <?php echo __d('shared_travels', '¿Puedo llevar mucho equipaje?')?></p>
            <p><?php echo __d('shared_travels', 'Siempre sugerimos considerar NO solicitar nuestro servicio si se lleva mucho equipaje. Esto se debe a que el auto va a ser compartido, y por tanto también el espacio del maletero.')?></p>
            <p><?php echo __d('shared_travels', 'Una maleta mediana por cada persona es aceptable, pero si las maletas son demasiado grandes entonces es mejor considerar viajar en bus.')?></p>
            <br/>
            <p class="lead">3. <?php echo __d('shared_travels', '¿Puedo hacer paradas para hacer fotos en lugares que me interesen dentro del recorrido?')?></p>
            <p><?php echo __d('shared_travels', 'NO realizamos paradas de tipo excursionistas porque el auto debe llegar a su destino a una hora adecuada para prestar otro servicio.')?></p>
            <p><?php echo __d('shared_travels', 'En los tramos largos (ej. La Habana - Trinidad) realizamos una parada en cafetería para merendar e ir al baño, y además se pueden solicitar otras paradas para cualquier otra necesidad.')?></p>
            <br/>            
            <br/>
            <a href="#transfers-available" class="btn btn-block btn-info"><big><?php echo __d('shared_travels', 'Ver las rutas y horarios disponibles')?></big></a>
        </div>
    </div>
</div>