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
                    <!--<img alt="Logo" src="./TruckPlease - Get quotes from local movers._files/logo-6273ab41968af780b3c919630482922f.png">-->
                        <span class="white"><i class="glyphicon glyphicon-road"></i> <big>Yo</big>Te<big>Llevo</big></span>
                    </a>
                </div>
                <div class="navbar-collapse navbar-ex1-collapse collapse" style="height: 1px; ">
                    <ul class="nav navbar-nav navbar-right">
                        <!--<li><a class="nav-link" href="https://www.truckplease.com/jobs/contents-of-a-2-400-sq-foot-house-including">Example Job</a></li>-->
                        <li><?php echo $this->Html->link(__('Entrar'), array('controller' => 'users', 'action' => 'login'), array('class'=>'nav-link'))?></li>
                        <li><?php echo $this->Html->link(__('Registrarse'), array('controller' => 'users', 'action' => 'register'), array('class'=>'nav-link')) ?></li>
                    </ul>
                </div>
            </nav>
        </div>

    </div>
    <h1 id="sell" class="handwritten white">Desata la creatividad en tus viajes</h1>
    <h2 class="handwritten-2 white">
		  Contacta con uno de nuestros <big><big><span class="text-info"><b>taxis</b></span></big></big> 
		  para moverte por <big><big><span class="text-info"><b>Cuba</b></span></big></big>
    </h2>
    <div style="padding-top:50px">
        <a href="#!" class="btn btn-success show-travel-form" style="font-size:20pt;white-space: normal;max-width:500px">
				Contactar un taxi
            <div style="font-size:12pt;padding-left:50px;padding-right:50px">
			Completa nuestro formulario y acuerda los términos del viaje con tu chofer
            </div>
        </a>
    </div>
</div>

<div class="row sell">
    <div class="col-md-4 center">
        <span class="glyphicon glyphicon-user"></span>
        <span class="glyphicon glyphicon-user"></span>
        <span class="glyphicon glyphicon-user"></span>
        <p class="sell-text">
			Te ponemos en contacto con hasta 3 de nuestros choferes para que acuerdes el viaje directamente con ellos.
        </p>
    </div>
    <div class="col-md-4 center">
        <span class="glyphicon glyphicon-comment"></span>
        <span class="glyphicon glyphicon-usd"></span>
        <p class="sell-text">
			Escoge el chofer que mejor se ajuste a tus requerimientos. Acuerda tus recorridos, horarios y el precio del viaje o ruta.
        </p>
    </div>
    <div class="col-md-4 center">
        <!--<span class="glyphicon glyphicon-road"></span>-->
        <span class="glyphicon glyphicon-briefcase"></span>
        <span class="glyphicon glyphicon-camera"></span>
        <span class="glyphicon glyphicon-music"></span>
        <p class="sell-text">
			Llegado el momento, haz tu viaje de la manera acordada, improvisa en el camino y crea los mejores recuerdos de esta isla fantástica.
        </p>
    </div>
</div>

</br>
<div class="container well" style="padding:15px;background-color:lightskyblue;">
    <div class="row">
        <div id="FormContainer">
            <legend style="text-align:center">
                Crea un Anuncio de Viaje
                <div><small><small>¿Ya estás registrado en <em>YoTeLlevo</em>? <?php echo $this->Html->link(__('Entra y mira tus anuncios'), array('controller' => 'users', 'action' => 'login')) ?></small></small></div>
            </legend>
            <?php echo $this->Session->flash(); ?>
            <?php echo $this->element('pending_travel_form', array('bigButton'=>true, 'horizontal'=>true)); ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.show-travel-form').click(function() {
            $('html, body').animate({
                scrollTop: $('#FormContainer').offset().top
            }, 300);
            $('#TravelOrigin').focus();
        });
        
        /*/ Make Html5 placeholder cross-browser
        $('[placeholder]').focus(function() {
		var input = $(this);
		if (input.val() == input.attr('placeholder')) {
			input.val('');
			input.removeClass('placeholder');
		}
	}).blur(function() {
		var input = $(this);
		if (input.val() == '' || input.val() == input.attr('placeholder')) {
			input.addClass('placeholder');
			input.val(input.attr('placeholder'));
		}
	}).blur();
	$('[placeholder]').parents('form').submit(function() {
		$(this).find('[placeholder]').each(function() {
			var input = $(this);
			if (input.val() == input.attr('placeholder')) {
				input.val('');
			}
		})
	});*/
    });
</script>