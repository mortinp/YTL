<div class="row">
    <div class="col-md-8 col-md-offset-3">
        
        <?php echo $this->element('addon_filters_for_search', array('filters_for_search'=>UserInteraction::$filtersForSearch))?>

        <div>Páginas: <?php echo $this->Paginator->numbers();?></div>
        <br/>
        <br/>

        <?php foreach ($interactions as $i):?>
        <p><?php echo $this->element('widget_user_interaction', array('interaction'=>$i))?></p>
        <br/>
        <?php endforeach ?>
        
        <br/>
        <div>Páginas: <?php echo $this->Paginator->numbers();?></div>
        
    </div>
</div>