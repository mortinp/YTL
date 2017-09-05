<?php App::uses('LangUtil', 'Util')?>

<div class="container">
    <div class="row" style="margin-top: 60px">
        <div class="col-md-10 col-md-offset-1">
            <br/>
            <p class="text-muted" style="text-align: center"><?php echo __d('catalog', '¿Necesitas un chofer con auto en Cuba?')?> <?php echo __d('catalog', 'Échale un vistazo a')?>...</p>
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
    
    <div class="row" style="padding-top: 90px;text-align: center" id="search">
        <div class="col-md-10 col-md-offset-1">
            <p class="lead"><?php echo __d('catalog', 'Primero, déjanos saber dónde comienza tu viaje para poder encontrar los mejores choferes')?>:</p>
            
            <div>
                <?php echo $this->Form->create('Search', array('class'=>'form-inline','type'=>'GET')); ?>
                <?php echo $this->Form->input('in', array('type'=>'text','label'=>false, 'class'=>'input-lg', 'placeholder'=>__d('catalog', 'Ej. La Habana, Trinidad, Santa Clara, Santiago de Cuba')));?>
                <?php if(isset($this->request->query['also'])) echo $this->Form->input('also', array('type'=>'hidden', 'value'=>$this->request->query['also']));?>
                <?php echo $this->Form->submit(__d('catalog', 'Encontrar choferes'), array('class'=>'btn btn-lg btn-info info','div'=>false, 'title'=>__d('catalog', 'Encontrar choferes en el origen de tu viaje (Ej. La Habana, Trinidad, Santiago de Cuba, Cayo Coco, etc.)')));?>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
    
    <div class="row" style="padding-top: 70px" id="reviews">
        <div class="col-md-10 col-md-offset-1">
            
            <h4 style="text-align: center"><?php echo __d('catalog', '... o podemos comenzar con los testimonios que hemos recibido recientemente')?>:</h4>
            <?php if((int)$this->Paginator->counter('{:pages}') > 1):?>
                <div style="text-align: center"><?php echo __d('catalog', '%s historias aquí... y hay más', count($testimonials))?>: <span style="display: inline-block"><?php echo $this->Paginator->numbers();?></span></div>
            <?php endif?>
                
            <?php 
            $currentLang = LangUtil::getLangSetup(Configure::read('Config.language'));
            
            $proposeAltLang = 
                    !isset($this->request->query['also']) 
                    || Configure::read('Config.language') == $this->request->query['also']
                    || !in_array($this->request->query['also'], array('en', 'es'));
            
            $query = null;
            if(isset($this->request->query['in'])) $query = '?in='.$this->request->query['in'];
            ?>  
                
            <?php if($proposeAltLang):?>
                <?php 
                $query = '?also='.$currentLang['alt'];
                if(isset($this->request->query['in'])) $query .= '&in='.$this->request->query['in'];
                $query .= '#search';
                ?> 
                <br/>
                <div style="text-align: center">
                    <span class="text-muted"><?php echo __d('catalog', 'Descubre más choferes')?>:</span>
                    <span style="display: inline-block"><?php echo $this->Html->link(__d('catalog', 'Mostrar también reseñas en %s', $currentLang['altDesc']), $query)?></span>
                </div>
            <?php else:?>
                <?php 
                $query = '';
                if(isset($this->request->query['in'])) $query .= '?in='.$this->request->query['in'];
                $query .= '#search';
                ?>
                <br/>
                <div style="text-align: center">
                    <span class="text-muted"><?php echo __d('catalog', 'Se muestran reseñas en %s e %s', $currentLang['desc'], $currentLang['altDesc'])?></span>
                    <div><?php echo $this->Html->link(__d('catalog', 'Mostrar sólo en %s', $currentLang['desc']), array('action'=>'catalog-drivers-cuba'.$query) )?></div>
                </div>
            <?php endif?>
                
            <br/><br/><br/>
            <?php
            foreach($testimonials as $data):?>
                <?php echo $this->element('testimonial_body', array('testimonial'=>$data['Testimonial'], 'driver'=>$data['Driver']));?>
                <br/><br/>
            <?php endforeach;?>
            
            <?php if((int)$this->Paginator->counter('{:pages}') > 1):?>
                <div><?php echo __d('testimonials', 'Mira más historias')?>: <span style="display: inline-block"><?php echo $this->Paginator->numbers();?></span></div>
            <?php endif?>
        </div>
    </div>
    
</div>