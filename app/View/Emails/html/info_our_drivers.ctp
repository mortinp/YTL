<?php App::uses('Driver', 'Model'); ?>
<?php 
$driver_name = Driver::shortenName($DriverProfile['driver_name']);

$fullBaseUrl = Configure::read('App.fullBaseUrl');
if(Configure::read('debug') > 0) $fullBaseUrl .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien

$avatar_url = $fullBaseUrl.'/'.str_replace('\\', '/', $DriverProfile['avatar_filepath']);
$profile_url = $this->html->url(array('controller' => 'drivers', 'action' => "profile", $DriverProfile['driver_nick']), true);
?>

<p>Hola <?php echo $driver_name?>, a continuación ponemos algunos datos que debes conocer sobre tu perfil en <a href="http://yotellevocuba.com">yotellevocuba.com</a>:</p>

<ol>
    <li>
        <p>Tu nombre completo en nuestro sitio es <b><?php echo $DriverProfile['driver_name']?></b>.</p>
    </li>
    
    <li>
        <p>Este es tu avatar, una pequeña foto que le llega a todos tus clientes en los correos que les envías:<br/></p>
        <img src='<?php echo $avatar_url?>' alt='No tienes avatar en tu perfil' />
    </li>
    <li>
        <p>Esta es la dirección de tu perfil en nuestro sitio web. Esta página la pueden visitar los clientes cuando les llegan tus respuestas:</p>
        <a href="<?php echo $profile_url ?>"><?php echo $profile_url ?></a>
        <p>Puedes compartir esta dirección en tu página de Facebook para que tus amigos y otros clientes potenciales la vean.</p>
    </li>
    <li>
        <p>Este es tu código personal para que tus clientes pongan testimonios sobre tí en tu perfil:</p>
        <div><b><?php echo ($DriverProfile['driver_code']) ? strtoupper($DriverProfile['driver_code']) : 'No tienes código en nuestro sitio'; ?></b></div>
        <p>Este código puedes dárselo a todos tus clientes (no solo a los de YoTeLlevo) y enviarlos a nuestro sitio para que pongan un testimonio sobre tí. Tener testimonios en nuestro sitio es muy importante para lograr atrapar viajeros.</p>
    </li>
    <li>
        <p>Tienes <b><?php echo $DriverStats['testimonials_approved']?></b> testimonios en tu perfil de un total de <big><b><?php echo $testimonials_total?></b></big> testimonios que hay en el sitio.</p>
    </li>
    <li>
        <p>Haz realizado <b><?php echo $DriverStats['travels_done'] ?></b> viajes con YoTeLlevo.</p>
    </li>
</ol>

<p>Si encuentras algún dato erróneo o quieres cambiar o mejorar algo (nombre, avatar, fotos del perfil, etc.) puedes responder este correo y decírnoslo. Enseguida te atenderemos.</p>

<p>Saludos y mucha suerte en los viajes,</p>

<p>Martín y el equipo de YoTeLlevo</p>