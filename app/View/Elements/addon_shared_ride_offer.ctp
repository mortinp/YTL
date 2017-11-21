<?php if($userLoggedIn && $userRole == 'admin' && in_array($data['Travel']['people_count'], array(2, 3))):?>
<div id="shared_ride_addon">
    <span class="alert alert-success" style="display: inline-block; width: 100%">
        <?php if(!$data['Travel']['User']['shared_ride_offered']):?>
            <b>Enviar oferta de viaje compartido</b>. Se enviará correo en <b><?php echo $data['Travel']['User']['lang'] == 'en'?'Inglés':'Español';?></b>
            <hr/>
            
            <?php echo $this->Form->create('Data', array('url' => array('controller' => 'driver_travels', 'action' =>'offer_shared_ride/'.$data['DriverTravel']['id']))); ?>
                <fieldset>
                <?php
                //echo $this->Form->input('conversation_id', array('type'=>'hidden'));
                echo $this->Form->input('name', array('type'=>'text', 'label'=>'Nombre(s) de los viajeros'));
                
                $langs = ($data['Travel']['User']['lang'] == 'es')? array('es'=>'Español', 'en'=>'English'): array('en'=>'English', 'es'=>'Español');
                echo $this->Form->input('lang', array(
                    'options' => $langs
                ));
                echo $this->Form->submit('Enviar oferta de viaje compartido', array('class'=>'btn-info btn btn-block', 'confirm' => 'Está a punto de enviar un correo de oferta de viaje compartido a este viajero. ¿Desea continuar?'));
                ?>
            </fieldset>
            <?php echo $this->Form->end(); ?>
            
        <?php else: ?>
        Ya se envió la oferta de viaje compartido...
        <?php endif; ?>
    </span>
</div>   
<?php endif; ?>