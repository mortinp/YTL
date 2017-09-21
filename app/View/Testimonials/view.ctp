<?php App::uses('Driver', 'Model')?>

<?php
$testimonial = $data['Testimonial'];

$driver_name = $data['Driver']['DriverProfile']['driver_name'];
?>

<div class="container">
    <div class="row">
        
        <div class="col-md-10 col-md-offset-1">
            <?php if(!$userLoggedIn && !$this->Session->read('introduced-in-website')):?>
                <span class="alert alert-info alert-dismissable" style="display: inline-block"><button type='button' class='close' data-dismiss='alert' aria-hidden='true'><big>&times;</big></button>
                    <p>
                        <?php echo __('Estás en el sitio web de <b>YoTeLlevo</b>, una plataforma que conecta viajeros que vienen a <b>Cuba</b> con <b>choferes privados</b> que operan en la isla.')?>
                        <?php echo __('Si necesitas un chofer en Cuba, probablemente puedas encontrarlo aquí.')?>
                    </p>
                </span>
            <?php endif?>
            <p>
                <?php echo __d('testimonials', 'Estás viendo un testimonio sobre %s, uno de nuestros choferes en %s, Cuba.', '<code><big>'.$driver_name.'</big></code>', '<code><big>'.$data['Driver']['Province']['name'].'</big></code>')?>
            </p>
            <p>
                <span style="display: inline-block"><?php echo $this->Html->link(__d('testimonials', 'Mira el perfil de %s', $driver_name), array('controller' => 'drivers', 'action' => 'profile/' . $data['Driver']['DriverProfile']['driver_nick'])) ?></span>
                &nbsp;|&nbsp;
                <span style="display: inline-block"><?php echo $this->Html->link(__d('testimonials', 'Descubre más choferes en nuestra Página de Testimonios', $driver_name), array('action' => 'featured'))?></span>
            </p>
            
            <br/>
            <br/>
            <?php echo $this->element('testimonial_body', array('testimonial' => $testimonial, 'driver'=>$data['Driver']));?>
        </div>
        
    </div>
</div>