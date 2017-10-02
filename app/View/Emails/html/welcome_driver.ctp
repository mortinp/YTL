<?php App::uses('TimeUtil', 'Util')?>
<?php App::uses('DriverTravel', 'Model')?>

<?php $driver_name = 'chofer'?>
<?php if($profile['driver_name'] != null) $driver_name = $profile['driver_name']?>
<p>Hola <?php echo $driver_name?>,</p>

<p>Le queremos dar formalmente la bienvenida a YoTeLlevo. Bienvenido! Ya usted forma parte de nuestra plataforma y esperamos que la misma le sea de mucho provecho.</p>

<p>Ya su perfil está listo y se encuentra activo en nuestro sitio web en:</p>

<?php $profileUrl = $this->Html->url(array('controller' => 'drivers', 'action' => "profile", $profile['driver_nick']), true);?>
<p><a href="<?php echo $profileUrl?>"><?php echo $profileUrl?></a></p>

<p>Queremos además comentarle rápidamente sobre algo que es de suma importancia para que pueda convencer a los viajeros: <b>usted debe tener opiniones de sus clientes en su página de perfil</b>.</p>

<p>Todos los clientes potenciales que lleguen a su perfil van a querer ver recomendaciones de clientes anteriores suyos, porque esa es la prueba de la calidad de sus servicios y de su experiencia.</p>

<p><b>¿Cómo hacer que sus clientes pongan una opinión sobre usted en su perfil de YoTeLlevo?</b></p>

<ol>
    <li>
        Debe darles su código personal de YoTeLlevo, que es:
        <p><b><?php echo strtoupper($profile['driver_code'])?></b></p>
    </li>
    <li>
        Debe decirles que vayan a nuestro sitio web y pongan ese código donde se les pide. Nuestro sitio web es:
        <p><b>yotellevocuba.com</b></p>
    </li>
</ol>

<p>Enseguida sus clientes van a poder escribir una opinión sobre usted. <b>Si ahora mismo está con clientes, puede probar a darles el código al finalizar el servicio y enviarlos a nuestro sitio</b>.</p>

<p>Un par de recomendaciones:</p>
<ul>
    <li>Los viajeros que dejan mejores opiniones son los que han viajado con usted durante varios días, porque se crea una relación más fuerte.</li>
    <li>Si puede tirarse una foto con ellos y decirles que la pongan junto con la opinión sería genial! La foto es muy importante siempre, aunque no es obligatorio.</li>
</ul>

<p>Al recibir una opinión usted será el primer chofer que se mostrará en nuestro catálogo, desde donde otros posibles clientes le pueden enviar una solicitud directamente sin que le llegue a otros choferes.</p>

<p>Muchos saludos y esperamos tenga en cuenta la sugerencia,</p>
<p>El equipo de <a href="http://yotellevocuba.com">YoTeLlevo</a></p>