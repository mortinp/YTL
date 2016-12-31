<?php 
    $webroot = $this->request->webroot; 
    
    $imagen_path = str_replace('\\', '/', $DriverProfile['avatar_filepath']);
    $urlPerfil = array('controller' => 'drivers', 'action' => "profile", $DriverProfile['driver_nick']);
    $fakenumber = 12;
?>


<p>
    <b>Avatar:</b>
    <?php echo "<img src='{$webroot}{$imagen_path}' alt='No has enviado la foto para el perfil' />"; ?>
</p>

<p>
    <b>NickName:</b> 
    <?php echo $DriverProfile['driver_nick']; ?>
</p>

<p>
    <a href="<?php echo $this->html->url($urlPerfil, true); ?>">La dirección de tu Perfil en YoTeLlevo</a>
</p>

<p>
    <b>Código Personal Para Testimonios:</b> 
    <?php echo ($DriverProfile['driver_code']) ? $DriverProfile['driver_code'] : 'No se ha definido el código'; ?>
</p>

<p>
    <b>Testimonios:</b>
    <?php 
        $total = $Testimonial['total'] + $fakenumber; 
        echo "Tienes {$Testimonial['approved']} testimonios aprobados de un total de $total"; 
    ?>
</p>

<p>
    <b>Viajes Realizados:</b>
    <?php echo $viajes_realizados; ?>
</p>