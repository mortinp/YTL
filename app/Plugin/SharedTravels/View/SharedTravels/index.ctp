<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3>Solicitudes de viajes compartidos (<?php echo count($travels)?>)</h3>
            
        <div>Páginas: <?php echo $this->Paginator->numbers();?></div>
        <br/>
        
        <?php foreach ($travels as $request) {
            echo $this->element('shared_travel', compact('request') + array('showDetails'=>true));
            echo '<br/><br/><hr/>';
        }?>
        
        <br/>
        <div>Páginas: <?php echo $this->Paginator->numbers();?></div>
        
    </div>
</div>