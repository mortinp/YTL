<?php $modality = SharedTravel::$modalities[$this->request->query['s']]?>

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
    <div class="center">
        <br/>
        <span class="white" style="font-size:20px;text-shadow:0 -1px 1px rgba(0,0,0,0.6)">
            <?php echo __d('homepage', '¿Necesitas llegar a tu destino en Cuba?') ?>
        </span>
        <br/>
        <span class="white" style="font-size:40px;text-shadow:0 -1px 1px rgba(0,0,0,0.6)">
            <?php echo __d('homepage', 'Comparte un auto cómodo con otros viajeros.') ?>
        </span>
        <br/>
        <span class="white" style="font-size:40px;text-shadow:0 -1px 1px rgba(0,0,0,0.6)">
            <?php echo __d('homepage', 'Haz tu viaje por un precio muy competitivo.') ?>
        </span>
    </div>
    
    <br/>
    <h2 class="handwritten-2 white">
        <div><?php echo __d('shared_travels', 'Autos modernos de 4 plazas. Aire acondicionado. Servicio puerta a puerta.') ?></div>
    </h2>
    <div class="sell-button" style="padding-top:50px">
        <a href="#!" class="btn btn-success goto" data-go-to="request-ride">
            <?php echo __d('shared_travels', 'Solicitar un transfer compartido') ?>
            <div class="sub">
                <?php echo __d('homepage', 'Te daremos confirmación en menos de 24 horas') ?>
            </div>
        </a>
    </div>
</div>

<div class="row" style="margin-top: 50px;text-align: center">
    
    <h2><?php echo __d('shared_travels', '¿Cómo funciona?')?></h2>
    
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

<div id="request-ride"class="row arrow_box arrow_box_bottom" style="margin-top: 80px"></div>
<div class="row" style="background-color: #ebebeb;padding-bottom: 20px">
    <div class="row" style="padding-top: 80px;">
        <div class="col-md-10 col-md-offset-1" style="text-align: center">
            <p class="lead">
                <?php echo __d('catalog', 'Solicita un transfer de %s a %s por un precio de %s por persona', 
                        '<code><big>'.$modality['origin'].'</big></code>', 
                        '<code><big>'.$modality['destination'].'</big></code>', 
                        '<code><big>'.$modality['price'].' CUC'.'</big></code>')?>
            </p>
            <p class="lead">
                <?php echo __d('catalog', 'Recogida en el lugar y fecha que usted indique, a las %s','<code><big>'.$modality['time'].'</big></code>')?>
            </p>
        </div>
        
        <div class="col-md-10 col-md-offset-1 center">
            <span class="alert alert-danger" style="display: inline-block"><?php echo __d('shared_travels', 'Considera NO solicitar este servicio si llevas mucho equipaje. El espacio del auto es compartido y queremos que todos viajen cómodos.')?></span>
        </div>
        
    </div>
    <div class="row" style="margin-top: 40px;">
        
        <div class="col-md-6 col-md-offset-1">
            <?php echo $this->element('shared_travel_form')?>
        </div>
        <div class="col-md-3 col-md-offset-1 alert alert-warning" style="display: inline-block">
            <p><b><?php echo __d('shared_travels', 'TÉRMINOS DEL SERVICIO')?></b></p><hr/>
            <ul>
               <li><?php echo __d('shared_travels', 'Servicio <b>compartido</b> en <b>auto moderno</b> de <b>4 plazas</b> con <b>aire acondicionado</b> y excelente confort.')?></li>
               <li><?php echo __d('shared_travels', 'Servicio <b>puerta a puerta</b> (recogida en casa u hotel y se deja en casa u hotel del destino).')?></li>
               <li><?php echo __d('shared_travels', 'La <b>recogida puede demorar hasta 30 minutos</b> después de la hora establecida para el servicio, pues el chofer planifica su recorrido para recoger a los 4 clientes.')?></li>
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