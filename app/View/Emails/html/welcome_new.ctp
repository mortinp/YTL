<?php  $urlDef = array('controller' => 'users', 'action' => 'confirm_email/' . $confirmation_code, 'base'=>false);?>

<p>
    <?php echo __d('user_email', 'Hola, le damos la bienvenida a YoTeLlevo.')?>
</p>

<p>
    <?php echo __d('user_email', 'Muchas gracias por decidir usar nuestra plataforma para encontrar un chofer con auto en Cuba. Por aquí podrá comunicarse con varios choferes que operan acá en la isla; ellos le harán sus ofertas de precios y usted podrá ver fotos de ellos, de sus autos, así como leer testimonios de otros viajeros. De esta forma usted podrá contratar a alguno si así lo desea.')?>
</p>

<p>
    <?php echo __d('user_email', 'Además de los choferes, usted tendrá un asistente de viajes que estará velando por que su experiencia con nuestra plataforma sea útil y que le saque el mejor provecho. <b>Si ya creó y confirmó su primera solicitud, ya debe haber recibido un correo de su asistente</b>.')?>
</p>

<p>
    <?php echo __d('user_email', 'Por último, puede ser que le interese solicitar otros viajes ahora o en el futuro. Para eso deberá confirmar su cuenta de correo dando click en %s', '<a href="'.$this->Html->url($urlDef, true).'">'.__d('user_email', 'este enlace').'</a>')?>
</p>

<p>
    <?php echo __d('user_email', 'Esperamos que pueda encontrar el chofer adecuado para su viaje, y que se divierta mucho durante su estancia en Cuba.')?>
</p>

<p>
    <?php echo __d('user_email', 'Disfrute mucho')?>!
</p>

<p>
    <?php echo __d('user_email', 'El equipo de <a href="http://yotellevocuba.com">YoTeLlevo</a>.')?>
</p>