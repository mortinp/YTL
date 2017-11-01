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
</p>

<p> 
    <b>Nombre del viajero:</b> <?php echo $testimonial['author']?> 
    <br/>
    <b>Email del viajero:</b> <?php echo $testimonial['email']?>
</p>

<p><?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $testimonial['text']);?></p>

<p><a href='<?php echo $this->Html->url($urlAdmin, true) ?>'>Administrar este testimonio</a></p>