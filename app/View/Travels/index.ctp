<div class="container">
    <div class="row">
    <?php if(!empty ($travels) || !empty ($travels_by_email)): ?>
        <div class="col-md-5">
            <h3>Tus Anuncios de Viajes</h3>
            <?php if(!empty ($travels)): ?>                
                <br/>

                <ul style="list-style-type: none;padding: 0px">
                <?php foreach ($travels as $travel) :?>                
                    <li style="margin-bottom: 20px">
                        <?php echo $this->element('travel', array('travel'=>$travel))?>
                    </li>                
                <?php endforeach; ?>
                </ul>
                <br/>
            <?php endif; ?>
            <?php if(!empty ($travels_by_email)): ?>
                <br/>
                <h3>Creados por Correo</h3>
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
        
        <div class="col-md-6 col-md-offset-1">
            <legend>Crear Anuncio de Viaje</legend>
            <?php echo $this->element('travel_form')?>
        </div>

    <?php else :?>
        <div class="col-md-6 col-md-offset-3">
            <p>
                No tienes ningún anuncio de viaje todavía. Crea uno ahora.
            </p>
            <legend>Crear Anuncio de Viaje</legend>
            <?php echo $this->element('travel_form')?>
        </div>
    <?php endif; ?>

    </div>
</div>