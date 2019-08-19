<div class="container">
    <div class="row">
    <?php if(!empty ($travels)): ?>
        <div class="col-md-6 col-md-offset-3">
            <h3>Anuncios Pendientes (Todos)</h3>
            <br/>
            <div>Páginas: <?php echo $this->Paginator->numbers();?></div>
            <br/>
            <ul style="list-style-type: none;padding: 0px">
            <?php foreach ($travels as $travel) :?>                
                <li style="margin-bottom: 50px">
                    <?php echo $this->element('pending_travel', array('travel'=>$travel, 'actions'=>false))?>
                </li>                
            <?php endforeach; ?>
            </ul>            
        </div>
    <?php else :?>
        No hay anuncios pendientes
    <?php endif; ?>
    </div>
</div>