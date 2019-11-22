<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <?php if(!empty ($driver_travels)): ?>
            
                <?php
                $direct_messages = array();
                $offer_messages = array();
                $travel = null;
                $data = array();
                $index = 0;
                foreach ($driver_travels as $dt) {
                    if($dt['DriverTravel']['notification_type'] == DriverTravel::$NOTIFICATION_TYPE_DIRECT_MESSAGE) {
                        $direct_messages[] = $dt;
                        continue;
                    }
                    
                    if($dt['DriverTravel']['notification_type'] == DriverTravel::$NOTIFICATION_TYPE_DISCOUNT_OFFER_REQUEST) {
                        $offer_messages[] = $dt;
                        continue;
                    }
                    
                    if($travel == null) {
                        $travel = $dt;
                        $data[] = array('request'=>$travel, 'conversations'=>array());
                    }
                    
                    if($dt['Travel']['id'] == $travel['Travel']['id']) {
                        $data[$index]['conversations'][] = $dt;
                    } else {
                        $travel = $dt;
                        $data[] = array('request'=>$travel, 'conversations'=>array($dt));
                        $index++;
                    }   
                }
                ?>
                <span>
                    <?php 
                    if(count($data) > 0 && count($direct_messages) && count($offer_messages))
                        echo __('Tienes %s conversaciones en %s solicitudes de viajes, %s conversaciones directas y %s conversaciones en ofertas', count($driver_travels), count($data),  count($direct_messages), count($offer_messages));
                    else if(count($data) > 0)
                        echo __('Tienes %s conversaciones en %s solicitudes de viajes', count($driver_travels), count($data));
                    else if(count($direct_messages) > 0)
                        echo __('Tienes %s conversaciones directas', count($direct_messages), count($data));
                    else if(count($offer_messages) > 0)
                        echo __('Tienes %s conversaciones de ofertas', count($offer_messages), count($data));
                    ?>
                </span>
                <hr/>
            
                <?php if(count($data) > 0):?>
                <br/>
                
                <ul style="list-style-type: none;padding: 0px">
                    
                    <?php
                        foreach ($data as $t) {
                        echo '<li style="margin-bottom: 60px">';
                        echo $this->element('conversation_widget_for_user/travel_data', array('travel'=>$t['request']));

                        echo '<ul style="list-style-type: none">';
                        foreach ($t['conversations'] as $c) {
                            echo '<li style="margin-bottom: 10px">';
                            echo $this->element('conversation_widget_for_user/conversation_data', array('conversation'=>$c));
                            echo '</li>';
                        }
                        echo '</ul>';
                        echo '</li>';
                    }
                    ?>
                </ul>
                <?php endif?>
                
                <?php if(count($direct_messages) > 0):?>
                <?php if(count($data) > 0):?><p><?php echo __('Otras conversaciones')?>:</p><?php endif?>
                <br/>
                
                <ul style="list-style-type: none;padding: 0px">
                    
                    <?php
                    foreach ($direct_messages as $t) {
                        echo '<li style="margin-bottom: 10px">';
                        echo $this->element('conversation_widget_for_user/conversation_data', array('conversation'=>$t));
                        echo '</li>';
                    }
                    ?>
                    <!--Las ofertas al final-->
                    <?php if(count($offer_messages) > 0):?>
                        </br>
                        <p><?php echo __('Ofertas:')?></p>
                        <?php
                        foreach ($offer_messages as $t) {
                            echo '<li style="margin-bottom: 10px">';
                            echo $this->element('conversation_widget_for_user/conversation_data', array('conversation'=>$t));
                            echo '</li>';
                        }
                        ?>
                    <?php endif?>
                </ul>
                <?php endif?>
                
                
                <br/>

        <?php else :?>
            <?php echo __('Aún no tienes mensajes con ningún chofer.')?>
            <hr/>
            <span class="alert alert-warning" style="display: inline-block">
                <?php echo __('Todos los mensajes que intercambies con los choferes aparecerán aquí. En cuanto recibas el primer mensaje de un chofer en tu correo, puedes venir y revisar.')?>
            </span>
        <?php endif; ?>
        </div>

    </div>
</div>