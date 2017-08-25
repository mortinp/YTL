<?php App::uses('DriverProfile', 'Model')?>

<?php
$talkingToDriver = $this->Session->read('visited-driver-'.$profile['Driver']['id']);
?>

<?php 
$driver_name = $profile['DriverProfile']['driver_name'];
$driver_short_name = Driver::shortenName($driver_name);
?>

<!-- TESTIMONIOS -->
<?php 
$testimonials = null;
if(isset ($profile['Testimonial']) && !empty ($profile['Testimonial'])) $testimonials = $profile['Testimonial'];
else if(isset ($profile['Driver']['Testimonial']) && !empty ($profile['Driver']['Testimonial'])) $testimonials = $profile['Driver']['Testimonial'];

$hasTestimonials = $testimonials != null && count($testimonials) > 0;
?>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        
        <?php if(!$userLoggedIn && !$this->Session->read('introduced-in-website')):?>
        <span class="alert alert-info alert-dismissable" style="display: inline-block"><button type='button' class='close' data-dismiss='alert' aria-hidden='true'><big>&times;</big></button>
            <p>
                <?php echo __d('driver_profile', 'Estás en el sitio web de <b>YoTeLlevo</b>, una plataforma que conecta viajeros que vienen a <b>Cuba</b> con <b>choferes privados</b> que operan en la isla.')?>
                <?php echo __d('driver_profile', 'Si necesitas un chofer en Cuba, probablemente puedas encontrarlo aquí.')?>
            </p>
            <p>
                <?php echo __d('driver_profile', 'Ahora mismo estás en el perfil de %s, uno de nuestros choferes.', '<code>'.$driver_name.'</code>')?>
            </p>
        </span>
        <?php endif?>
        
        <div>
            <h3><img src="<?php echo DriverProfile::getAbsolutePath($profile['DriverProfile']['avatar_filepath'])?>"/> <span style="display: inline-block"><?php echo __d('driver_profile', 'Conoce a %s un poco más...', $driver_name)?></span></h3>
        </div>
        <hr/>
        
        <div>
            <p><?php echo __d('driver_profile', 'Datos rápidos sobre %s', $driver_name)?>:</p>
            <div><?php echo __d('driver_profile', '<span class="text-muted">Vive en</span> %s', $profile['Province']['name'])?></div>
            <div>
                <?php echo __d('driver_profile', '<span class="text-muted">Auto hasta</span> %s pax', $profile['Driver']['max_people_count'])?>
                <?php if($profile['Driver']['has_air_conditioner']) echo __d('driver_profile', '<span class="text-muted">con</span> aire acondicionado')?>
            </div>
            <div><?php if($hasTestimonials):?><a href="#reviews"><?php echo __d('driver_profile', '<span class="text-muted">Tiene</span> %s opiniones', count($testimonials))?></a><?php endif?></div>
        </div>
        <br/>
        
        <br/>
        <div>
            <?php echo $profile['DriverProfile']['description_'.Configure::read('Config.language')]?>
        </div>
    </div>
    
    <div class="col-md-8 col-md-offset-2" style="padding-top: 30px;">
    <?php if(AuthComponent::user('role') === 'admin'):?>
        <?php echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i> Editar este perfil', array('action'=>'edit_profile/'.$profile['Driver']['id']), array('escape'=>false))?>
    <?php endif?>
    </div>
</div>

<?php if($hasTestimonials):?>

<div class="row">
    
    <div class="col-md-8 col-md-offset-2" id="reviews">
        <span class="lead">
            <?php echo __d('driver_profile', '%s tiene %s opiniones', $driver_short_name, count($testimonials))?>
        </span>
        <hr/>
    </div>
    
    <?php $i = 0?>
    <?php foreach ($testimonials as $testimonial):?>
        <div class="col-md-8 col-md-offset-2">
            <?php echo $this->element('testimonial_body', array('testimonial'=>$testimonial));?>
            <br/>
            <br/>
        </div>
        <?php $i++?>
    <?php endforeach?>
    
</div>
<?php endif?>


<?php if(!$talkingToDriver):?>
<br/>
<div class="row">
    <?php
    $class = 'col-md-10 col-md-offset-1';
    if($userLoggedIn) $class = 'col-md-6 col-md-offset-3';
    ?>
    <div class="<?php echo $class?>">
        <div class="row arrow_box arrow_box_bottom"></div>
        <div class="bg-info row">
            <div class="row">
                <div id="message-driver" style="margin-top: 25px;padding: 15px;padding-top: 25px;">
                    <legend style="text-align:center">
                        <div class="handwritten-2"><big><big><?php echo __d('driver_profile', 'Haz un viaje sorprendente con %s', $driver_name) ?></big></big></div>
                        <div><small><?php echo __d('driver_profile', '<b>Envía un mensaje a %s</b> para comenzar a acordar tus recorridos con él.', $driver_name) ?></small></div>
                    </legend>
                    <?php echo $this->Session->flash(); ?> 
                    <br/>
                    <?php echo $this->element('form_write_to_driver')?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif?>


<?php echo $this->element('addon_scripts_send_form', array('formId'=>'EnterCodeForm', 'submitId'=>'EnterCodeSubmit'))?>

<!--
<?php if(!$userLoggedIn):?>
<br/><br/>
<?php echo $this->element('addon_driver_profile_popup', array('driver_short_name'=>$driver_short_name))?>
<?php endif?>
-->

<script type="text/javascript">
$(document).ready(function() {
    $('.goto').click(function() {
        goTo( $(this).data('go-to') ); 
    });
    
});

function goTo(id) {
    $('html, body').animate({
        scrollTop: $('#' + id).offset().top
    }, 300);
};
</script>