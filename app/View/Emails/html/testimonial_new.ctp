<?php /* --  $travel, $driver, $driver_profile, $user -- */ ?>

<?php
$urlAdmin = array('controller' => 'testimonials', 'action' => "admin/{$testimonial['id']}");
if (isset($travel))
    $urlViaje = array('controller' => 'travels', 'action' => "admin", $travel['id']);
?>

<p> 
    <?php
    $driver_name = '---';
    if (isset($driver['DriverProfile']['driver_name']))
        $driver_name = $driver['DriverProfile']['driver_name'];
    ?>
    <b>Chofer:</b> <?php echo $driver_name?>
    <?php
    /*if (isset($travel)):
        echo "<b>Viaje:</b>";
        ?>
        <a href='<?php echo $this->Html->url($urlViaje, true) ?>'> <?php echo $travel['id']; ?> </a>
        <br>
        <?php
        echo "<b>Desde:</b> {$travel['origin']} <br>";
        echo "<b>Hasta:</b> {$travel['destination']}";
    endif;*/
    ?> 
</p>

<p> 
    <b>Nombre del viajero:</b> <?php echo $testimonial['author']?> 
    <br/>
    <b>Email del viajero:</b> <?php echo $testimonial['email']?>
</p>

<p><?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $testimonial['text']);?></p>

<p><a href='<?php echo $this->Html->url($urlAdmin, true) ?>'>Administrar este testimonio</a></p>