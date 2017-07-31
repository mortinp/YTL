<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <?php if(!empty ($driver_travels)): ?>
            
                <?php 
                $travel = $driver_travels[0];
                $data = array();
                $data[] = array('request'=>$travel, 'conversations'=>array());
                $index = 0;
                foreach ($driver_travels as $dt) {
                    if($dt['Travel']['id'] == $travel['Travel']['id']) {
                        $data[$index]['conversations'][] = $dt;
                    }
                    else {
                        $travel = $dt;
                        $data[] = array('request'=>$travel, 'conversations'=>array($dt));
                        $index++;
                    }   
                }
                ?>
                <span><?php echo __('Tienes %s conversaciones en %s solicitudes de viajes', count($driver_travels), count($data))?></span>
                <hr/>
            
                <br/>
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
                <br/>

        <?php else :?>
            <?php echo __('Aún no tienes mensajes con ningún chofer.')?>
            <hr/>
        <?php endif; ?>
        </div>

    </div>
</div>