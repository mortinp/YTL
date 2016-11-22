<?php 
if(!isset($actions)) $actions = false;
if(!isset($details)) $details = true;
?>
<div class="container">
    <div class="row">
    <?php if(!empty ($travels)): ?>
        <div class="col-md-8 col-md-offset-2">
            <h3>Solicitudes de Viajes (<?php echo count($travels)?>)</h3>
            
            <div>Páginas: <?php echo $this->Paginator->numbers();?></div>
            <br/>
            <?php echo $this->element('addon_filters_for_search', array('filters_for_search'=>Travel::$filtersForSearch))?>
            <br/>
            <br/>

            <?php if(!empty ($travels)): ?>                
                <br/>

                <ul style="list-style-type: none;padding: 0px">
                <?php foreach ($travels as $travel) :?>                
                    <li style="margin-bottom: 60px">
                        <?php echo $this->element('travel', array('travel'=>$travel, 'actions'=>$actions, 'details'=>$details))?>
                    </li> 
                <?php endforeach; ?>
                </ul>
                
                <br/>
            <?php endif; ?>
                
            <div>Páginas: <?php echo $this->Paginator->numbers();?></div>
        </div>

    <?php else :?>
        No hay anuncios de viajes
    <?php endif; ?>

    </div>
</div>

<?php echo $this->element('addon_scripts_notify_driver')?>