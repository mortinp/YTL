<?php 
if(!isset($actions)) $actions = false;
if(!isset($details)) $details = true;
?>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h3>Conversaciones (<?php echo count($driver_travels)?>)</h3>
            <div>Filtros: 
                <ul>
                <?php 
                    foreach (DriverTravel::$filtersForSearch as $filter) {
                        echo '<li style="display:inline-block;padding-right:20px">';

                        if(!isset ($filter_applied)) echo $this->Html->link($filter, array('action'=>'view_filtered/'.$filter));
                        else if($filter != $filter_applied) echo $this->Html->link($filter, array('action'=>'view_filtered/'.$filter));
                        else echo '<span class="badge"><big>'.$filter.'</big></span>';

                        echo '</li>';
                    }
                ?>
                </ul>
            </div>

            <div>Páginas: <?php echo $this->Paginator->numbers();?></div>
            <?php if(!empty ($driver_travels)): ?>
            
                <br/>
                <br/>

                <ul style="list-style-type: none;padding: 0px">
                <?php foreach ($driver_travels as $dt) :?>                
                    <li style="margin-bottom: 60px">
                        <?php echo $this->element('driver_travel', array('driver_travel'=>$dt));?>
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