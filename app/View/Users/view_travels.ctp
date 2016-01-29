<div class="container">
    <div class="row">
    <?php if(!empty ($travels) || !empty ($travels_by_email)): ?>
        <div class="col-md-6 col-md-offset-3">
            <h3>Anuncios de Viajes del usuario <?php echo $user['User']['username']?></h3>
            <?php if(!empty ($travels)): ?>                
                <br/>

                <ul style="list-style-type: none;padding: 0px">
                <?php foreach ($travels as $travel) :?>                
                    <li style="margin-bottom: 60px">
                        <?php echo $this->element('travel', array('travel'=>$travel, 'actions'=>false, 'details'=>true))?>
                    </li>                
                <?php endforeach; ?>
                </ul>
                <br/>
            <?php endif; ?>
            
        </div>

    <?php else :?>
        No hay anuncios de viajes
    <?php endif; ?>

    </div>
</div>


<?php echo $this->element('addon_scripts_notify_driver')?>