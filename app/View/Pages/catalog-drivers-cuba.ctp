<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <br/>
            <h1 style="text-align: center"><?php echo __d('catalog', 'El Asombroso Catálogo de Choferes en Cuba')?></h1> 
            <br/>
            <h4 style="text-align: center">... <?php echo __d('catalog', 'basado en testimonios de sus clientes')?></h4>
            
            <hr/>
        </div>
    </div>
    
    <div class="row" style="margin-top: 50px;text-align: center">
        <h3><?php echo __d('catalog', '¿Cómo funciona?')?></h3>
        <br/>
        <div class="col-md-2 center col-md-offset-1">
            <?php echo __d('catalog', 'Tenemos muchos choferes con autos que operan en Cuba. Los viajeros que vienen a la isla reseñan el servicio de su chofer en nuestro sitio web usando un código personal secreto que les damos.')?>
        </div>
        <div class="col-md-2 center">
            <?php echo __d('catalog', 'En nuestro sitio mostramos las reseñas, pero sólo mostramos a los choferes que han recibido al menos una reseña en los últimos 3 meses. Esto asegura que esos choferes estén operando activamente.')?>
        </div>
        <div class="col-md-2 center">
            <?php echo __d('catalog', 'Cada reseña tiene un enlace a la página personal del chofer. Puedes navegar estas páginas personales y ver fotos de los choferes y sus autos, así como otras reseñas de clientes anteriores.')?>
        </div>
        <div class="col-md-2 center">
            <?php echo __d('catalog', 'Desde la página personal de cada chofer puedes enviarles un mensaje directo con los detalles de tu viaje, y pedir una oferta de precio. Te comunicas directamente con el chofer mientras arreglas todos los términos del servicio.')?>
        </div>
        <div class="col-md-2 center">
            <?php echo __d('catalog', 'Finalmente contratas un chofer, y una vez en Cuba te encuentras con él y usas su servicio. Al finalizar tu viaje contribuyes a nuestra comunidad dejando una reseña sobre tu chofer')?> :)
        </div>
        
    </div>
    
    <div class="row" style="padding-top: 70px">
        <div class="col-md-10 col-md-offset-1">
            
            <h4 style="text-align: center"><?php echo __d('catalog', 'Entonces, empecemos con los testimonios que hemos recibido recientemente')?>:</h4>
            <?php if((int)$this->Paginator->counter('{:pages}') > 1):?>
                <div style="text-align: center"><?php echo __d('catalog', '%s historias aquí... y hay más', count($testimonials))?>: <?php echo $this->Paginator->numbers();?></div>
                <br/>
                <br/>
            <?php endif?>
                
            <div class="text-muted" style="text-align: center"><?php echo __d('catalog', 'Recuerda que puedes navegar las páginas de los choferes desde las reseñas', count($testimonials))?></div>
            
            <br/><br/>  
            <?php
            foreach($testimonials as $data):?>
                <?php echo $this->element('testimonial_body', array('testimonial'=>$data['Testimonial'], 'driver'=>$data['Driver']));?>
                <br/><br/>
            <?php endforeach;?>
            
            <?php if((int)$this->Paginator->counter('{:pages}') > 1):?>
                <div><?php echo __d('testimonials', 'Mira más historias')?>: <?php echo $this->Paginator->numbers();?></div>
            <?php endif?>
        </div>
    </div>
    
</div>