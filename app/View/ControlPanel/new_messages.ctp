<?php 
if(!isset($actions)) $actions = false;
if(!isset($details)) $details = true;
?>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h3>Conversaciones con nuevos mensajes (<?php echo count($conversations)?>)</h3>
            
            <div>Páginas: <?php echo $this->Paginator->numbers();?></div>
            <?php if(!empty ($conversations)): ?>
            
                <ul style="list-style-type: none;padding: 0px">
                <?php foreach ($conversations as $dt) :?>
                    <li style="margin-bottom: 60px">
                        <?php echo $this->element('conversation_widget', array('conversation'=>$dt));?>
                    </li> 
                <?php endforeach; ?>
                </ul>

                <br/>

        <?php else :?>
            No hay conversaciones
        <?php endif; ?>
            <div>Páginas: <?php echo $this->Paginator->numbers();?></div>
        </div>

    </div>
</div>