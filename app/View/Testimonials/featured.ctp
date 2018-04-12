<?php App::uses('LangUtil', 'Util')?>

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <?php if(!$userLoggedIn && !$this->Session->read('introduced-in-website')):?>
            <span class="alert alert-info alert-dismissable" style="display: inline-block"><button type='button' class='close' data-dismiss='alert' aria-hidden='true'><big>&times;</big></button>
                <p>
                    <?php echo __('Estás en el sitio web de <b>YoTeLlevo</b>, una plataforma que conecta viajeros que vienen a <b>Cuba</b> con <b>choferes privados</b> que operan en la isla.')?>
                    <?php echo __('Si necesitas un chofer en Cuba, probablemente puedas encontrarlo aquí.')?>
                </p>
                <p>
                    <?php echo __d('testimonials', 'Ahora mismo estás en nuestra <code>página de Testimonios</code>.')?>
                </p>
            </span>
            <?php endif?>
            
            <br/>
            <p><?php echo __d('testimonials', 'Estas son algunas opiniones, comentarios e historias de viajeros que han hecho recorridos y transfers con nuestros choferes. Lee algunas, inspírate y anímate a contratar a algún chofer con auto aquí en Cuba.')?></p> 
            <!--<br/>
            <p class="text-muted"><?php echo __d('testimonials', 'Puedes visitar la página personal de cada chofer desde los testimonios')?>.</p> 
            -->
            <br/>
            
            <?php if((int)$this->Paginator->counter('{:pages}') > 1):?>
                <div><?php echo __d('testimonials', '%s historias aquí... y hay más', count($testimonials))?>: <span style="display: inline-block"><?php echo $this->Paginator->numbers(array('modulus'=>20));?></span></div>
                
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
                    ?> 
                    <br/>
                    <div>
                        <span class="text-muted"><?php echo __d('testimonials', 'Descubre más choferes')?>:</span>
                        <span style="display: inline-block"><?php echo $this->Html->link(__d('testimonials', 'Mostrar también reseñas en %s', $currentLang['altDesc']), $query)?></span>
                    </div>
                <?php else:?>
                    <?php 
                    $query = '';
                    if(isset($this->request->query['in'])) $query .= '?in='.$this->request->query['in'];
                    ?>
                    <br/>
                    <div>
                        <span class="text-muted"><?php echo __d('testimonials', 'Se muestran reseñas en %s e %s', $currentLang['desc'], $currentLang['altDesc'])?></span>
                        - <span><?php echo $this->Html->link(__d('testimonials', 'Mostrar sólo en %s', $currentLang['desc']), array('action'=>'featured'.$query) )?></span>
                    </div>
                <?php endif?>

                <br/><br/><br/>
            <?php endif?>
        </div>
        
        <div class="col-md-10 col-md-offset-1">
            <?php
            foreach($testimonials as $i=>$data):?>
                <div>
                    <?php echo $this->element('testimonial_body', array('testimonial'=>$data['Testimonial'], 'driver'=>$data['Driver']/*, 'nameAsLink'=>false*/));?>
                </div>
            
                <div>
                    <hr/>
                    <?php $driver_name = Driver::shortenName($data['Driver']['DriverProfile']['driver_name']);?>
                    <?php $driver_nick = $data['Driver']['DriverProfile']['driver_nick'];?>
                    
                    <?php if($data['Driver']['active']):?>
                        <div style="float: left;margin-right: 30px;margin-bottom: 30px">
                            <p><small><?php echo __d('driver_profile', 'Datos rápidos sobre %s', '<b>'.$driver_name.'</b>')?>:</small></p>
                            <div><small><?php echo __d('driver_profile', '<span class="text-muted">Vive en</span> %s', $data['Driver']['Province']['name'])?></small></div>
                            <div>
                                <small>
                                <?php echo __d('driver_profile', '<span class="text-muted">Auto hasta</span> %s pax', $data['Driver']['max_people_count'])?>
                                <?php if($data['Driver']['has_air_conditioner']) echo __d('driver_profile', '<span class="text-muted">con</span> aire acondicionado')?>
                                </small>
                            </div>
                        </div>
                        <div>
                            <?php echo $this->Html->link('<div style="font-size:12pt">'.__d('testimonials', 'Mira más sobre %s en su perfil', $driver_name).' »</div>'.'<div style="font-size:10pt">'.__d('testimonials', 'También podrás contactarlo', $driver_name).'</div>', array('controller'=>'drivers', 'action'=>'profile', $driver_nick), array('class'=>'btn btn-info', 'target'=>'_blank', 'escape'=>false))?>
                        </div>
                    <?php else:?>
                        <span class="text-muted"><?php echo __d('testimonials', '%s no está activo en nuestro sitio y su perfil no es accesible', '<b>'.$driver_name.'</b>')?></span>
                    <?php endif?>
                </div>
                
            
                <br/><br/><br/><br/><br/><br/>
                
                <!-- Poner el formulario de solicitud despues del nth testimonio -->
                <?php if($i == 4):?>
                    <div style="padding-top:30px;padding-bottom:30px;background-color: #ebebeb">
                        <div style="text-align: center">
                            <p><?php echo __d('testimonials', '¿Ya te gustan nuestros choferes?')?></p>
                            <p class="lead"><?php echo __d('testimonials', 'Contacta con %s de ellos creando una solicitud de viaje', 3)?></p>
                            <hr/>
                        </div>
                        <?php echo $this->Session->flash(); ?>            
                        <?php echo $this->element('pending_travel_form', array('bigButton' => true, 'horizontal' => true)); ?>
                    </div>
                <br/><br/><br/><br/><br/><br/>
                <?php endif?>
                
                
            <?php endforeach;?>
            
            <?php if((int)$this->Paginator->counter('{:pages}') > 1):?>
                <div><?php echo __d('testimonials', 'Mira más historias')?>: <span style="display: inline-block"><?php echo $this->Paginator->numbers();?></span></div>
            <?php endif?>
        </div>

    </div>
</div>