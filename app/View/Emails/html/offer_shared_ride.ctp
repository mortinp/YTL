<?php
$otherTravelers = __d('emails/offer_shared_ride', 'otros %s pasajeros', 4 - $people_count);
if($people_count == 3) $otherTravelers = __d('emails/offer_shared_ride', 'otro pasajero');
$savePercent = 100 - $people_count*25;

if(!isset ($traveler_name) || $traveler_name == null) $traveler_name = '';
else $traveler_name = ' '.$traveler_name;
?>

<p><?php echo __d('emails/offer_shared_ride', 'Hola')?><?php echo $traveler_name?>,</p>

<p><?php echo __d('emails/offer_shared_ride', 'Soy %s de YoTeLlevoCuba.com, el sitio web donde han estado buscando un taxi con chofer para hacer algunos traslados acá en Cuba.', 'Martín')?></p>

<p><?php echo __d('emails/offer_shared_ride', 'Quería en este correo darles las gracias por usar nuestro servicio. MUCHÍSIMAS GRACIAS!... y además quería ofrecerles una pequeña ayuda.')?></p>

<p><?php echo __d('emails/offer_shared_ride', 'Les comento que recientemente lanzamos <b>un nuevo servicio de taxi compartido que es mucho más económico que un taxi privado</b>. La idea es que siendo ustedes %s personas, harían cada traslado con %s y así se ahorrarían el %s del precio total en cada traslado.', $people_count, $otherTravelers, $savePercent.'%')?></p>

<p><?php echo __d('emails/offer_shared_ride', '¿Qué les parece? Un taxi compartido puede ser una buena alternativa.')?></p>

<p><?php echo __d('emails/offer_shared_ride', 'Si les interesara compartir el taxi y hacer traslados más económicos, podrían ver la página web y los precios aquí debajo (nuestro nuevo servicio se llama PickoCar):')?></p>

<p style="padding-bottom:10px;padding-top:10px">
    <a  style="padding:10px;color: #333;background-color: #ebebeb;border-color: #adadad;text-decoration: none"
        href="https://pickocar.com/<?php echo Configure::read('Config.language')?>"
        target="_blank"><b><?php echo __d('emails/offer_shared_ride', 'Valorar opción y precios de taxi compartido en Cuba')?> »</b>
    </a>
</p>

<p><?php echo __d('emails/offer_shared_ride', 'Debo adicionar además que en este servicio se les recoge en su casa de alquiler u hotel donde se hospeden. Es similar a lo que ofertamos en YoTeLlevo, pero compartiendo el taxi con otros pasajeros.')?></p>

<p><?php echo __d('emails/offer_shared_ride', 'Creo que podría ser una buena opción, por eso se las recomiendo.')?></p>

<p><?php echo __d('emails/offer_shared_ride', 'Déjenme saber por favor cualquier pregunta que tengan, %s. Estaré encantado de poderles ayudar.', $traveler_name)?></p>

<p><?php echo __d('emails/offer_shared_ride', 'Saludos cordiales desde Cuba y les deseo un magnífico viaje a la isla!')?></p>

<p><?php echo __d('emails/offer_shared_ride', '%s y el equipo de %s', 'Martín', '<a href="https://yotellevocuba.com">YoTeLlevo</a>')?></p>