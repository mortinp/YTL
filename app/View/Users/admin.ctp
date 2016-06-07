<div class="row">
    <div class="col-md-8 col-md-offset-3">
        <legend>Usuario</legend>
        <div>
            Correo: <?php echo $user['User']['username']?>
            <?php echo $this->Html->link($user['User']['travel_count'].' viajes', array('action'=>'view_travels/'.$user['User']['id']))?>
        </div>
        
        <?php
        if(AuthComponent::user('username') == 'mproenza@grm.desoft.cu' || AuthComponent::user('username') == 'martin@yotellevocuba.com') {
            echo '<br/>';
            echo $this->Form->button('<i class="glyphicon glyphicon-home"></i> '.'Enviar propuesta de casas', array('plugin'=>'casas', 'controller'=>'casas', 'action'=>'send_proposal_find_casas/'.$user['User']['id'], 'escape'=>false, 'class'=>'btn-primary', 'confirm'=>'¿Está seguro que quiere gestionarle casas a este viajero?', 'title'=>'Se le enviará un correo a los viajeros para que confirmen si desean que nuestros expertos les consigan casas.'), true);
        }
        ?>
        
        <br/>
        <br/>
        <legend>Interacciones</legend>       
        <?php         
        $types = array(
            UserInteraction::$INTERACTION_TYPE_FIND_CASAS=>array(), 
            UserInteraction::$INTERACTION_TYPE_CHANGE_PASSWORD=>array(), 
            UserInteraction::$INTERACTION_TYPE_CONFIRM_EMAIL=>array(),
            UserInteraction::$INTERACTION_TYPE_WRITE_REVIEW=>array(),
            UserInteraction::$INTERACTION_TYPE_NOTIFY_MORE_DRIVERS=>array());
        
        foreach ($interactions as $i) $types[$i['UserInteraction']['interaction_due']][] = $i;
        ?>
        
        <?php foreach ($types as $k=>$t):?>
        <?php echo $k?>
        <ul>
            <?php foreach ($t as $i):?>
            <li>
                <?php echo $this->element('widget_user_interaction', array('interaction'=>$i))?>
            </li>
            <?php endforeach ?>
        </ul>
        <?php endforeach ?>
        
    </div>
</div>