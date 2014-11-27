<h2>Hola Viajero,</h2>
<div>
    <p>
        El <em>Origen</em> y <em>Destino</em> especificados en el asunto de tu correo no son reconocidos por <em>YoTeLlevo</em>. 
        Por favor chequea que <em><b><?php echo $user_origin ?></b></em> y <em><b><?php echo $user_destination ?></b></em> 
        estén bien escritos. Nuestros especialistas analizarán dichas localidades para programar su inclusión
        en el sistema. Aquí te mostramos un listado de las localidades que manejamos hasta el momento<!--, 
        y otros términos--> y que puedes usar como <em>Origen</em> o como <em>Destino</em> de tus viajes:
    </p>
</div>
<div> 
    <p>
    <?php
    echo '<b>Localidades:</b> ';
    
    $sep = '';
    foreach ($localities as $province => $municipalities) {
        foreach ($municipalities as $munId=>$munName) {
            echo $sep.$munName;
            $sep = ', ';
        }
    }
    ?>
    </p>
    
    <!--<p>
    <?php
    echo '<b>Términos:</b> ';
    
    $sep = '';
    foreach ($thesaurus as $t) {
        echo $sep.$t['LocalityThesaurus']['fake_name'];
        $sep = ', ';
    }
    ?>
    </p>-->
</div>

<div>
    <p>
    Si alguna de estas localidades <!--o términos--> te es conveniente, vuelve a escribir un correo a 
    <b><a href="mailto:viajes@<?php echo Configure::read('domain_name')?>">viajes@<?php echo Configure::read('domain_name')?></a></b>
    usando una de ellas en el asunto como <em>Origen</em> o como <em>Destino</em>.
    </p>
</div>

<div>
    <p>
        También te dejamos aquí algunas sugerencias para que tu viaje se haga efectivo:
    </p>
    <ul>
        <li>Escribe el nombre completo del lugar. Por ejemplo, escribe <em>Aeropuerto José Martí</em>.</li>
        <li>Si el recorrido tiene más de un destino, escribe sólo el primer destino. Cuando el chofer te contacte, puedes hablarle de los destinos restantes.</em></li>
    </ul>    
</div>