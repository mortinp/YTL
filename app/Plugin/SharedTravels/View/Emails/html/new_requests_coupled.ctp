<?php App::uses('SharedTravel', 'SharedTravels.Model')?>

<p>Hola Andiel, tenemos un viaje completo de 4 pax formado con <?php echo count($requests) - 1?> solicitudes que aún no habías confirmado y una que acabamos de recibir.</p>

<p><b>NOTA: Este viaje ya fue confirmado a los clientes.</b></p>

<p>A continuación los detalles de las solicitudes:</p>

<?php for ($i=0;$i<count($requests);$i++):?>
    <?php $request = $requests[$i]?>
    <div>
        <b><?php echo $i + 1?>.</b>
        <?php echo $this->element('shared_travel_facilitator', compact('request'))?>
    </div>
    <br/>
    <br/>
<?php endfor;?>