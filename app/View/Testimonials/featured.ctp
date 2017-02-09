<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <br/>
            <p><?php echo __d('testimonials', 'Estas son algunas opiniones, comentarios e historias de viajeros que han hecho recorridos y transfers con nuestros choferes. Lee algunas, inspírate y anímate a contratar a algún chofer con auto aquí en Cuba.')?></p> 
            <br/>
            <br/>
        </div>
        
        
        <div class="col-md-10 col-md-offset-1">
            
            <?php if((int)$this->Paginator->counter('{:pages}') > 1):?>
                <div><?php echo __d('testimonials', '... y hay más historias')?>: <?php echo $this->Paginator->numbers();?></div>
                <br/>
                <br/>
            <?php endif?>
            
            <?php
            foreach($testimonials as $data){
                echo $this->element('testimonial_body', array('testimonial'=>$data['Testimonial']));
                echo '<br/><br/>';
            }   
            ?>
            
            <?php if((int)$this->Paginator->counter('{:pages}') > 1):?>
                <div><?php echo __d('testimonials', 'Mira más historias')?>: <?php echo $this->Paginator->numbers();?></div>
            <?php endif?>
        </div>

    </div>
</div>