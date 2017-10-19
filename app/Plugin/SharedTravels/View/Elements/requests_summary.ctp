<?php foreach ($requests as $r):?>
    <?php
    $modCode = $r['SharedTravel']['modality_code'];
    $mod = SharedTravel::$modalities[$modCode];
    ?>
    <div style="margin-bottom: 20px">
        <div><?php echo __d('shared_travels', '%s personas desde %s hasta %s el día %s con recogida a las %s.', '<b>'.$r['SharedTravel']['people_count'].'</b>', '<b>'.$mod['origin'].'</b>', '<b>'.$mod['destination'].'</b>', '<b>'.TimeUtil::prettyDate($r['SharedTravel']['date'], false).'</b>', '<b>'.$mod['time'].'</b>')?></div>
        <?php $urlDef = array('language'=>$r['SharedTravel']['lang'], 'controller' => 'shared_travels', 'action' => 'view/' . $r['SharedTravel']['id_token'], 'base'=>false) ?>
        <div><?php echo strtoupper(SharedTravel::getStateDesc($r['SharedTravel']['state']))?></div>
        <div><a href='<?php echo $this->Html->url($urlDef, true) ?>'><?php echo __d('shared_travels', 'Ver datos de esta solicitud')?></a></div>
    </div>
<?php endforeach?>