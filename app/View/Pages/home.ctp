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
                    <a class="navbar-brand" href="#!">
                        <span class="white"><big>Yo</big>Te<big>Llevo</big></span>
                    </a>
                    <div class="pull-left navbar-brand">
                        <?php $lang = SessionComponent::read('app.lang');?>
                        <?php if($lang != null && $lang == 'en'):?>
                            <?php echo $this->Html->link($this->Html->image('Spain.png').' Español', array('controller' => 'lang', 'action' => 'setlang', 'es'), array('class' => 'nav-link', 'title'=>'Traducir al Español', 'escape'=>false)) ?>
                        <?php else:?>
                            <?php echo $this->Html->link($this->Html->image('UK.png').' English', array('controller' => 'lang', 'action' => 'setlang', 'en'), array('class' => 'nav-link', 'title'=>'Translate to English', 'escape'=>false)) ?>
                        <?php endif;?>
                    </div>
                </div>
                <div class="navbar-collapse navbar-ex1-collapse collapse" style="height: 1px;">
                    <ul class="nav navbar-nav navbar-right">
                        <li><?php echo $this->Html->link(__d('homepage', 'Entrar'), array('controller' => 'users', 'action' => 'login'), array('class' => 'nav-link')) ?></li>
                        <li><?php echo $this->Html->link(__d('homepage', 'Registrarse'), array('controller' => 'users', 'action' => 'register'), array('class' => 'nav-link')) ?></li>
                    </ul>
                </div>
            </nav>
        </div>

    </div>
    <h1 id="sell" class="handwritten white"><?php echo __d('homepage', 'Sé el dueño de tu viaje') ?></h1>
    <h2 class="handwritten-2 white">
        <?php echo __d('homepage', 'Consigue el <big><big><span class="text-info"><b>taxi</b></span></big></big> de tu elección para moverte por <big><big><span class="text-info"><b>Cuba</b></span></big></big>') ?> 
    </h2>
    <div class="sell-button" style="padding-top:50px">
        <a href="#!" class="btn btn-success show-travel-form">
            <?php echo __d('homepage', 'Contactar un taxi') ?>
            <div class="sub">
                <?php echo __d('homepage', 'Acuerda enseguida los detalles del viaje con tu chofer') ?>
            </div>
        </a>
    </div>
</div>

<br/>

<div class="row sell">
    <div class="col-md-4 center">
        <span class="glyphicon glyphicon-user"></span>
        <span class="glyphicon glyphicon-user"></span>
        <span class="glyphicon glyphicon-user"></span>
        <p class="lead">
            <?php echo __d('homepage', 'Te ponemos en contacto con hasta <big>3</big> de nuestros choferes para que acuerdes el viaje directamente con ellos via correo electrónico') ?>.
        </p>
    </div>
    <div class="col-md-4 center">
        <span class="glyphicon glyphicon-comment"></span>
        <span class="glyphicon glyphicon-usd"></span>
        <p class="lead">
            <?php echo __d('homepage', 'Acuerda tus recorridos, horarios y el precio del viaje o ruta. Escoge el chofer que mejor se ajuste a tus requerimientos') ?>.
        </p>
    </div>
    <div class="col-md-4 center">
        <span class="glyphicon glyphicon-briefcase"></span>
        <span class="glyphicon glyphicon-camera"></span>
        <span class="glyphicon glyphicon-music"></span>
        <p class="lead">
            <?php echo __d('homepage', 'Llegado el momento, haz tu viaje de la manera acordada, improvisa en el camino y crea los mejores recuerdos de esta isla fantástica') ?>.
        </p>
    </div>
</div>

<!-- START THE FEATURETTES -->
<div class="featurette-container arrow_box arrow_box_bottom">

    <hr class="featurette-divider">

    <div class="row featurette">
        <div class="col-md-5">
            <?php echo $this->Html->image('driver.jpg', array('class' => 'featurette-image img-responsive img-circle')) ?>
        </div>
        <div class="col-md-7">
            <h2 class="featurette-heading"><?php echo __d('homepage', 'Házte amigo de tu chofer') ?></h2>
            <br/>
            <br/>
            <p class="lead"><?php echo __d('homepage', 'El chofer con quien viajas es importante y hace la diferencia. Nuestros choferes son pilotos, pescadores, profesionales, todos propietarios de un taxi que nos ayudan a moverte por la isla. Conecta con tu chofer de la manera que prefieras.') ?></p>
        </div>
    </div>

    <hr class="featurette-divider">
    
    <div class="row featurette">
        <div class="col-md-push-7 col-md-5">
            <?php echo $this->Html->image('budget-plan.jpg', array('class' => 'featurette-image img-responsive img-circle')) ?>
        </div>
        <div class="col-md-pull-5 col-md-7">
            <h2 class="featurette-heading"><?php echo __d('homepage', 'Planifica tu presupuesto de antemano') ?></h2>
            <br/>
            <br/>
            <p class="lead"><?php echo __d('homepage', 'Planifica los costos de transportación con tu chofer antes de llegar a la isla. Asegúrate de cuánto puedes disponer para otras actividades y ahórrate las sorpresas de tener que negociar tarifas con choferes en el momento de llegar.') ?></p>
        </div>
    </div>

    <hr class="featurette-divider">
    
    <div class="row featurette">
        <div class="col-md-5">
            <?php echo $this->Html->image('taxi-pick.jpg', array('class' => 'featurette-image img-responsive img-circle')) ?>
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
            <?php echo $this->Html->image('collage.jpg', array('class' => 'featurette-image img-responsive img-circle')) ?>
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

<div id="travel-create">
    <div class="row">
        <div id="FormContainer" style="margin-top: 25px;padding: 15px;padding-top: 25px;">
            <legend style="text-align:center">
                <div class="handwritten-2"><big><big><?php echo __d('homepage', 'Haz un viaje sorprendente con tu chofer') ?></big></big></div>
                <div><small><?php echo __d('homepage', '<b>Consigue un taxi</b> creando un Anuncio de Viaje') ?></small></div>
            </legend>
            <?php echo $this->Session->flash(); ?>
            
            <?php if($lang != 'es'):?>
            <div style="padding:20px;padding-left:30px"><span class="text-danger"><small>* Origin and Destination in Spanish for a better match, i.e. La Habana, Cayo Coco, Aeropuerto José Martí</small></span></div>
            <?php endif;?>
            
            <?php echo $this->element('pending_travel_form', array('bigButton' => true, 'horizontal' => true)); ?>
        </div>
    </div>
</div>

<div class="arrow_box arrow_box_top">
    <div class="row sell">
        <div class="col-md-12 center">
            <p class="lead">
                <?php echo __d('homepage', '¿Necesitas ideas? Estos son destinos populares con origen en') ?> <span class="handwritten" style="font-size: 24pt;display:inline-block">La Habana</span>
            </p>
        </div>
        <div class="col-sm-6 col-md-3 center">
            <a href="#!" style="text-decoration: none">
                <div class="destination-thumb img-rounded varadero">
                    <p class="handwritten white dest" style="font-size: 24pt">Varadero</p>
                    <h1 class="action white"><?php echo __d('homepage', 'Conseguir taxi') ?> <b>La Habana-Varadero</b></h1>
                </div>
            </a>
        </div>
        <div class="col-sm-6  col-md-3 center">
            <a href="#!" style="text-decoration: none">
                <div class="destination-thumb img-rounded trinidad">
                    <p class="handwritten white dest" style="font-size: 24pt">Trinidad</p>
                    <h1 class="action white"><?php echo __d('homepage', 'Conseguir taxi') ?> <b>La Habana-Trinidad</b></h1>
                </div>
            </a>
        </div>
        <div class="col-sm-6  col-md-3 center">
            <a href="#!" style="text-decoration: none">
                <div class="destination-thumb img-rounded vinales">
                    <p class="handwritten white dest" style="font-size: 24pt">Viñales</p>
                    <h1 class="action white"><?php echo __d('homepage', 'Conseguir taxi') ?> <b>La Habana-Viñales</b></h1>
                </div>
            </a>
        </div>
        <div class="col-sm-6  col-md-3 center">
            <a href="#!" style="text-decoration: none">
                <div class="destination-thumb img-rounded all-around">
                    <p class="handwritten white dest" style="font-size: 24pt"><?php echo __d('homepage', 'Recorrido por la isla') ?></p>
                    <h1 class="action white"><?php echo __d('homepage', 'Conseguir taxi') ?> <b>La Habana-<?php echo __d('homepage', 'Recorrido por la isla') ?></b></h1>
                </div>
            </a>
        </div>
    </div>
</div>


<script type="text/javascript">
    
    function goTo(id) {
        $('html, body').animate({
            scrollTop: $('#' + id).offset().top
        }, 300);
    };
    
    $(document).ready(function() {
        
        
        $('.show-travel-form').click(function() {
            goTo('FormContainer');            
            $('#PendingTravelOrigin').focus();
        });
        
        $('.destination-thumb').click(function() {
            goTo('FormContainer');
            $('#PendingTravelOrigin').val('La Habana');
            $('#PendingTravelDestination').val($(this).find('.dest').text());
            $('#PendingTravelDate').focus();
        });
    });
</script>