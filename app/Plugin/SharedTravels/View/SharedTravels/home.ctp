<?php     
    $other = array('en' => 'es', 'es' => 'en');
    $lang = $this->Session->read('Config.language');

    $lang_changed_url             = $this->request['pass'];
    $lang_changed_url             = array_merge($lang_changed_url, $this->request['named']);
    $lang_changed_url['?']        = $this->request->query;
    $lang_changed_url['language'] = $other[$lang];
?>
<div id="front-page-bg">
    <div id="navgradient">
        <div id="navbar">
            <nav id="nav">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                        <span class="white navbar-brand"><big>Yo</big>Te<big>Llevo</big></span>
                    <div class="pull-left navbar-brand">
                        <?php $lang = SessionComponent::read('app.lang');?>
                        <?php if($lang != null && $lang == 'en'):?>
                            <?php echo $this->Html->link($this->Html->image('Spain.png').' Español', $lang_changed_url, array('class' => 'nav-link', 'title'=>'Traducir al Español', 'escape'=>false)) ?>
                        <?php else:?>
                            <?php echo $this->Html->link($this->Html->image('UK.png').' English', $lang_changed_url, array('class' => 'nav-link', 'title'=>'Translate to English', 'escape'=>false)) ?>
                        <?php endif;?>
                    </div>
                </div>
                <div class="navbar-collapse navbar-ex1-collapse collapse" style="height: 1px;">
                   
                </div>
            </nav>
        </div>

    </div>
    <h1 id="sell" class="handwritten white"><?php echo __d('homepage', '¿Necesitas llegar a tu destino en Cuba?') ?></h1>
    <h2 class="handwritten-2 white">
        <div><big><?php echo __d('shared_travels', 'Contrata un servicio de transfer cómodo por un precio muy competitivo') ?></big></div>
        </h2>
    <div class="sell-button" style="padding-top:50px">
        <a href="#!" class="btn btn-success show-travel-form">
            <?php echo __d('shared_travels', 'Ver características del servicio') ?>
            <div class="sub">
                <?php echo __d('homepage', 'Te daremos confirmación en menos de 24 horas') ?>
            </div>
        </a>
    </div>
</div>

<div class="row" style="margin-top: 50px;text-align: center">
    <h2><?php echo __d('shared_travels', 'Ofertamos transfers desde La Habana hasta 3 destinos')?></h2>
    <br/>
    <div class="row featurette">
        <div class="col-md-5">
            <div class="destination-thumb img-rounded varadero">
                <p class="handwritten white dest" style="font-size: 24pt">Varadero</p>
                <h1 class="action white"><?php echo __d('homepage', 'Conseguir taxi') ?> <b>La Habana-Varadero</b></h1>
            </div>
        </div>
        <div class="col-md-7">
            <h2 class="featurette-heading"><?php echo __d('homepage', 'Servicio confortable') ?></h2>
            <br/>
            <br/>
            <p class="lead"><?php echo __d('homepage', 'Le enviaremos un auto moderno de 4 plazas, con aire acondicionado y todo el confort esperado.') ?></p>
        </div>
    </div>
    <div class="col-md-2 center col-md-offset-1 lead">
        <?php echo __d('shared_travels', 'Realizas la solicitud del servicio y esta llega a nosotros inmediatamente.')?>
    </div>
    <div class="col-md-2 center lead">
        <?php echo __d('shared_travels', 'Enseguida hacemos todos los arreglos y te confirmamos en menos de 24 horas.')?>
    </div>
    <div class="col-md-2 center lead">
        <?php echo __d('shared_travels', 'Te asignamos un operador con quien mantendrás comunicación.')?>
    </div>
    <div class="col-md-2 center lead">
        <?php echo __d('shared_travels', 'Cuando llega la fecha, enviamos el auto a tu puerta a recogerte.')?>
    </div>
    <div class="col-md-2 center lead">
        <?php echo __d('shared_travels', 'Finalmente haces un viaje feliz hasta tu destino')?> :)
    </div>

</div>

<div class="row" style="margin-top: 50px;text-align: center">
    <h2><?php echo __d('shared_travels', '¿Cómo funciona?')?></h2>
    <br/>
    <div class="col-md-2 center col-md-offset-1 lead">
        <?php echo __d('shared_travels', 'Realizas la solicitud del servicio y esta llega a nosotros inmediatamente.')?>
    </div>
    <div class="col-md-2 center lead">
        <?php echo __d('shared_travels', 'Enseguida hacemos todos los arreglos y te confirmamos en menos de 24 horas.')?>
    </div>
    <div class="col-md-2 center lead">
        <?php echo __d('shared_travels', 'Te asignamos un operador con quien mantendrás comunicación.')?>
    </div>
    <div class="col-md-2 center lead">
        <?php echo __d('shared_travels', 'Cuando llega la fecha, enviamos el auto a tu puerta a recogerte.')?>
    </div>
    <div class="col-md-2 center lead">
        <?php echo __d('shared_travels', 'Finalmente haces un viaje feliz hasta tu destino')?> :)
    </div>

</div>


<!-- START THE FEATURETTES -->
<div class="featurette-container arrow_box arrow_box_bottom">

    <hr class="featurette-divider">

    <div class="row featurette">
        <div class="col-md-5">
            <?php echo $this->Html->image('driver.jpg', array('class' => 'featurette-image img-responsive img-circle', 'alt'=>__d('homepage', 'Chofer de taxi sonriendo'))) ?>
        </div>
        <div class="col-md-7">
            <h2 class="featurette-heading"><?php echo __d('homepage', 'Servicio confortable') ?></h2>
            <br/>
            <br/>
            <p class="lead"><?php echo __d('homepage', 'Le enviaremos un auto moderno de 4 plazas, con aire acondicionado y todo el confort esperado.') ?></p>
        </div>
    </div>

    <hr class="featurette-divider">
    
    <div class="row featurette">
        <div class="col-md-push-7 col-md-5">
            <?php echo $this->Html->image('budget-plan.jpg', array('class' => 'featurette-image img-responsive img-circle', 'alt'=>__d('homepage', 'Pareja planeando presupuesto de viaje'))) ?>
        </div>
        <div class="col-md-pull-5 col-md-7">
            <h2 class="featurette-heading"><?php echo __d('homepage', 'Puerta a puerta') ?></h2>
            <br/>
            <br/>
            <p class="lead"><?php echo __d('homepage', 'La recogida se realiza directamente en la puerta de la casa u hotel donde usted se hospeda, y se deja en la dirección exacta de su destino.') ?></p>
        </div>
    </div>

    <hr class="featurette-divider">
    
    <div class="row featurette">
        <div class="col-md-5">
            <?php echo $this->Html->image('taxi-pick.jpg', array('class' => 'featurette-image img-responsive img-circle', 'alt'=>__d('homepage', 'Familia subiendo al auto'))) ?>
        </div>
        <div class="col-md-7">
            <h2 class="featurette-heading"><?php echo __d('homepage', 'No pierdas tiempo esperando transporte') ?></h2>
            <br/>
            <br/>
            <p class="lead"><?php echo __d('homepage', '¿Por qué esperar por un bus para llegar a dónde quieres? ¿Por qué ajustarte a su horario de salida? Tu tiempo en Cuba es limitado y es mejor tener un taxi a tu disposición y decidir cuándo moverte y hacia qué lugar. Es tan simple como recostarte en tu asiento y dejarte llevar.') ?></p>
        </div>
    </div>
    
    <hr class="featurette-divider">

    <div class="row featurette">
        <div class="col-md-push-7 col-md-5">
            <?php echo $this->Html->image('collage.jpg', array('class' => 'featurette-image img-responsive img-circle', 'alt'=>__d('homepage', 'Varios destinos turísticos en Cuba'))) ?>
        </div>
        <div class="col-md-pull-5 col-md-7">
            <h2 class="featurette-heading"><?php echo __d('homepage', 'Desata tu creatividad') ?></h2>
            <br/>
            <br/>
            <p class="lead"><?php echo __d('homepage', 'Cuba es un país hermoso para visitar y recorrer, y ninguno de sus lugares es igual. Arma tu viaje de la manera que quieras. Decide dónde quieres ir sin ajustarte a itinerarios rígidos y aburridos. Haz cambios de última hora cuando desees, aprende y decide en el camino y crea los mejores recuerdos.') ?></p>
        </div>
    </div>
</div>
<!-- /END THE FEATURETTES -->

<div class="row" style="padding-top: 90px;text-align: center" id="search">
    <div class="col-md-10 col-md-offset-1">
        <p class="lead"><?php echo __d('catalog', '<span class="text-muted">Servicio</span> compartido <span class="text-muted">en</span> auto moderno <span class="text-muted">de</span> 4 plazas <span class="text-muted">con</span> aire acondicionado <span class="text-muted">y excelente confort.</span>')?></p>
    </div>
</div>


<div class="row" style="margin-top: 50px;">
    <div class="col-md-6 col-md-offset-1">
        <?php echo $this->element('shared_travel_form')?>
    </div>
    <div class="col-md-3 col-md-offset-1 alert alert-info" style="display: inline-block">
        <p><b><?php echo __d('shared_travels', 'TÉRMINOS DEL SERVICIO')?></b></p><hr/>
        <ul>
           <li><?php echo __d('shared_travels', 'Servicio <b>compartido</b> en <b>auto moderno</b> de <b>4 plazas</b> con <b>aire acondicionado</b> y excelente confort.')?></li>
           <li><?php echo __d('shared_travels', 'Servicio <b>puerta a puerta</b> (recogida en casa u hotel y se deja en casa u hotel del destino).')?></li>
           <li><?php echo __d('shared_travels', 'La <b>recogida puede demorar hasta 30 minutos</b> después de la hora establecida para el servicio, pues el chofer planifica su recorrido para recoger a los 4 clientes.')?></li>
           <li><?php echo __d('shared_travels', 'El <b>pago es en efectivo y en CUC</b> directamente al chofer al efectuarse la recogida.')?></li>
        </ul>
    </div>
</div>