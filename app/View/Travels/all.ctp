<?php 
if(!isset($actions)) $actions = false;
if(!isset($details)) $details = true;
?>
<div class="container">
    <div class="row">
    <?php if(!empty ($travels) || !empty ($travels_by_email)): ?>
        <div class="col-md-6 col-md-offset-3">
            <h3>Anuncios de Viajes (Todos)</h3>
            <?php if(!empty ($travels)): ?>                
                <br/>

                <ul style="list-style-type: none;padding: 0px">
                <?php foreach ($travels as $travel) :?>                
                    <li style="margin-bottom: 20px">
                        <?php echo $this->element('travel', array('travel'=>$travel, 'actions'=>$actions, 'details'=>$details))?>
                    </li>                
                <?php endforeach; ?>
                </ul>
                <br/>
            <?php endif; ?>
            <?php if(!empty ($travels_by_email)): ?>
                <br/>
                <big><b>&mdash; Creados por Correo &mdash;</b></big>
                <br/>
                <br/>

                <ul style="list-style-type: none;padding: 0px">
                <?php foreach ($travels_by_email as $travel) :?>                
                    <li style="margin-bottom: 20px">
                       <?php echo $this->element('travel_by_email', array('travel'=>$travel, 'actions'=>$actions))?>
                       <b>Creado por:</b> <?php echo $travel['User']['username']?>
                    </li>                
                <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

    <?php else :?>
        No hay anuncios de viajes
    <?php endif; ?>

    </div>
</div>