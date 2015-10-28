<div class="container">
    <div class="row">
    <?php if(!empty ($travels) || !empty ($travels_by_email)): ?>
        <div class="col-md-6 col-md-offset-3">
            <?php echo __('Estos son todos tus anuncios de viajes')?>:
            <?php if(!empty ($travels)): ?>                
                <br/>
                <br/>

                <ul style="list-style-type: none;padding: 0px">
                <?php foreach ($travels as $travel) :?>                
                    <li style="margin-bottom: 40px">
                        <?php echo $this->element('travel', array('travel'=>$travel))?>
                    </li>                
                <?php endforeach; ?>
                </ul>
                <br/>
            <?php endif; ?>
            <?php if(!empty ($travels_by_email)): ?>
                <br/>
                <h3><?php echo __('Creados por Correo')?></h3>
                <br/>

                <ul style="list-style-type: none;padding: 0px">
                <?php foreach ($travels_by_email as $travel) :?>                
                    <li style="margin-bottom: 20px">
                       <?php echo $this->element('travel_by_email', array('travel'=>$travel))?>
                    </li>                
                <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        
        <!--<div class="col-md-6 col-md-offset-1 well" id="FormContainer" style="background-color: lightgoldenrodyellow">
            <legend><?php echo __('Crear Anuncio de Viaje')?></legend>
            <?php echo $this->element('travel_form')?>
        </div>-->

    <?php else :?>
        <div class="col-md-6 col-md-offset-3">
            <p>
                <?php echo __('No tienes ningún anuncio de viaje todavía. Crea uno ahora.')?>
            </p>
            <legend><?php echo __('Crear un anuncio de viaje')?></legend>
            <?php echo $this->element('travel_form')?>
        </div>
    <?php endif; ?>

    </div>
</div>