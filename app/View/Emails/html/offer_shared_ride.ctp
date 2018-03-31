<?php
$otherTravelers = __d('user_email', 'otros %s viajeros', 4 - $people_count);
if($people_count == 3) $otherTravelers = __d('user_email', 'otro viajero');

if(!isset ($traveler_name) || $traveler_name == null) $traveler_name = '';
else $traveler_name = ' '.$traveler_name;
?>

<p><?php echo __d('user_email', 'Hola')?><?php echo $traveler_name?>,</p>

<p><?php echo __d('user_email', 'Soy %s de YoTeLlevoCuba.com, el sitio web donde han estado buscando un chofer aquí en Cuba para hacer algunos recorridos.', 'Martín')?></p>

<p><?php echo __d('user_email', 'Quería en este correo darles las gracias por usar nuestro servicio. MUCHÍSIMAS GRACIAS!... y además quería ofrecerles una pequeña ayuda.')?></p>

<p><?php echo __d('user_email', 'He podido notar que <b>NO les ha sido muy útil nuestro sitio</b> porque no se han decidido por ningún chofer.')?></p>

<p><b><?php echo __d('user_email', '¿Quizás el problema es que el precio para contratar un chofer privado es demasiado alto?')?></b></p>

<p><?php echo __d('user_email', 'Quiero comentarles que recientemente lanzamos un nuevo servicio que permite abaratar mucho los costos para ir de un destino a otro en Cuba, compartiendo un taxi con otros viajeros que van al mismo destino, de manera que cada pasajero pague sólo por los asientos que ocupe.')?></p>

<p><?php echo __d('user_email', 'La idea principal es que por ejemplo, si van de La Habana a Trinidad, compartan un auto moderno de 4 plazas con %s y así el costo del viaje es mucho más bajo para cada uno, porque comparten el precio del viaje completo también.', $otherTravelers)?></p>

<p><?php echo __d('user_email', 'Estos son algunos de los precios que ofrecemos')?>:</p>

<ul>
    <li>La Habana - Viñales: <?php echo __d('user_email', '%s por persona', '<b>25 cuc</b>')?>, <?php echo __d('user_email', 'mejor que <b>%s por un viaje privado</b>', '100-120 cuc')?></li>
    <li>Trinidad - La Habana: <?php echo __d('user_email', '%s por persona', '<b>35 cuc</b>')?>, <?php echo __d('user_email', 'mejor que <b>%s por un viaje privado</b>', '130-150 cuc')?></li>
    <li>Trinidad - Cayo Guillermo: <?php echo __d('user_email', '%s por persona', '<b>40 cuc</b>')?>, <?php echo __d('user_email', 'mejor que <b>%s por un viaje privado</b>', '140-180 cuc')?></li>
    <li>Cayo Guillermo - La Habana: <?php echo __d('user_email', '%s por persona', '<b>50 cuc</b>')?>, <?php echo __d('user_email', 'mejor que <b>%s por un viaje privado</b>', '200-250 cuc')?></li>
</ul>

<p><?php echo __d('user_email', 'Estos son algunos ejemplos, pero cubrimos muchas otras rutas también.')?></p>

<p><?php echo __d('user_email', 'En el caso de ustedes que son <b>%s personas</b>, un viaje de La Habana a Trinidad les costaría <b>%s</b> en total. Es mucho más bajo que un chofer privado!', $people_count, 35*$people_count.' cuc')?></p>

<p><?php echo __d('user_email', 'Nuestro nuevo servicio de llama PickoCar, y aquí pueden ver todos los detalles')?>:</p>

<p><a href="http://pickocar.com">PickoCar.com</a></p>

<p><?php echo __d('user_email', 'Debo adicionar además que en este servicio se les recoge en su casa de alquiler u hotel donde se hospeden. Dependiendo del horario que reserven, un chofer les recogerá puntual en el lugar pactado para llevarlos hasta su destino.')?></p>

<p><?php echo __d('user_email', '¿Qué les parece?')?></p>

<p><?php echo __d('user_email', 'Creo que podría ser una buena opción, por eso se las recomiendo.')?></p>

<p><?php echo __d('user_email', 'Déjenme saber por favor cualquier pregunta que tengan. Estaré encantado de poderlos ayudar.')?></p>

<p><?php echo __d('user_email', 'Saludos cordiales desde Cuba y les deseo un magnífico viaje a la isla!')?></p>

<p>Martín, CEO YoTeLlevoCuba.com / PickoCar.com</p>