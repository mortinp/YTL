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
$testimonialsCount = $this->request->paging['Testimonial']['count'];
$hasTestimonials = $testimonials != null && count($testimonials) > 0;
?>

<?php $topPosition = 60?>
<div id="fixed" class="row" style="width: 100%;position: fixed;top: <?php echo $topPosition?>px;z-index: 100;background-color: white;padding:10px;border-bottom: #efefef solid 3px;">

    <div class="col-md-8 col-md-offset-2">
        <img id="driver-avatar" class="pull-left" src="<?php echo DriverProfile::getAbsolutePath($profile['DriverProfile']['avatar_filepath'])?>" style="max-width:60px"/> 
        <span style="display: inline-block; margin-left: 20px" class="h4">
            <span class="visible-lg visible-md visible-sm"><?php echo __d('driver_profile', 'Conoce a %s un poco más...', $driver_name)?></span>
            <span class="visible-xs"><?php echo $driver_name?></span>
            <div><small class="text-muted"><?php echo __d('driver_profile', 'Chofer de taxi en %s, Cuba', $profile['Province']['name'])?></small></div>
        </span>

        <?php if($userLoggedIn && $userRole === 'admin'):?>
            <span style="margin-left: 30px;">
                <?php echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i> Editar este perfil', array('action'=>'edit_profile/'.$profile['Driver']['id']), array('escape'=>false))?>
            </span>
        <?php endif?>
    </div>

</div>
<div style="height: <?php echo $topPosition + 20?>px;"></div> <!-- Separator -->

<div class="row" style="margin-top: 50px">
    
    <?php if(!$userLoggedIn && !$this->Session->read('introduced-in-website')):?>
    <div class="col-md-8 col-md-offset-2">
        <span class="alert alert-info alert-dismissable" style="display: inline-block"><button type='button' class='close' data-dismiss='alert' aria-hidden='true'><big>&times;</big></button>
            <p>
                <?php echo __('Estás en el sitio web de <b>YoTeLlevo</b>, una plataforma que conecta viajeros que vienen a <b>Cuba</b> con <b>choferes privados</b> que operan en la isla.')?>
                <?php echo __('Si necesitas un chofer en Cuba, probablemente puedas encontrarlo aquí.')?>
            </p>
            <p>
                <?php echo __d('driver_profile', 'Ahora mismo estás en el perfil de %s, uno de nuestros choferes.', '<code>'.$driver_name.'</code>')?>
            </p>
        </span>
    </div>
    <?php endif?>
    
    <div class="col-md-8 col-md-offset-2">
        <p style="font-size: 12pt"><b><?php echo __d('driver_profile', 'Datos rápidos sobre %s', $driver_name)?></b></p>
        <div><big><?php echo __d('driver_profile', '<span class="text-muted">Vive en</span> %s', $profile['Province']['name'])?></big></div>
        <div>
            <big>
                <?php echo __d('driver_profile', '<span class="text-muted">Auto hasta</span> %s pax', $profile['Driver']['max_people_count'])?>
                <?php if($profile['Driver']['has_air_conditioner']) echo __d('driver_profile', '<span class="text-muted">con</span> aire acondicionado')?>
            </big>
        </div>
        <?php if($hasTestimonials):?><div><a href="#reviews" style="color: inherit"><big><?php echo __d('driver_profile', '<span class="text-muted">Tiene</span> %s opiniones', $testimonialsCount)?></big></a></div><?php endif?>
    </div>
    
    <div class="col-md-8 col-md-offset-2" id="profile-description" style="margin-top: 50px">
        <?php $desc = json_decode($profile['DriverProfile']['description_'.Configure::read('Config.language')], true)?>
        <?php if($desc != null):?>
            <p style="font-size: 12pt"><b><?php echo __d('driver_profile', 'Fotos de %s', $driver_name)?></b></p>
            <div>
                <?php foreach ($desc['pics'] as $pic):?>
                    <?php
                    $attr = '';
                    foreach ($pic as $prop=>$val) {
                        $attr .= $prop.'="'.$val.'" ';
                    }
                    ?>
                    <img <?php echo $attr?> class="img-responsive" style="padding: 5px"/>
                <?php endforeach?>
            </div>
        <?php else:?>
            <?php echo $profile['DriverProfile']['description_'.Configure::read('Config.language')]?>
        <?php endif?>
    </div>
    
</div>

<?php if($hasTestimonials):?>
<div id="reviews" class="row" style="margin-top: 50px">
    <div class="col-md-8 col-md-offset-2">
        <p style="font-size: 12pt"><b><?php echo __d('driver_profile', 'Opiniones sobre %s (%s opiniones)', $driver_name, $testimonialsCount)?></b></p>
    </div>
    <div style="margin-top: 30px"><?php echo $this->element('ajax_testimonials_list', compact('testimonials')); ?></div>
</div>
<?php endif?>


<?php if(!$talkingToDriver):?>
<div class="row" style="margin-top: 50px">
    <div class="col-md-8 col-md-offset-2">
        <div class="row arrow_box arrow_box_bottom"></div>
        <div class="row bg-info">
            <div class="row">
                <div id="message-driver" style="margin-top: 25px;padding: 15px;padding-top: 25px;">
                    <div style="height: 50px;clear: both"></div>
                    <div style="text-align:center"><?php echo __d('driver_profile', '¿Necesitas un chofer con auto en Cuba?') ?></div>
                    <legend style="text-align:center">
                        <div class="handwritten-2"><big><big><?php echo __d('driver_profile', 'Haz un viaje sorprendente con %s', $driver_name) ?></big></big></div>
                        <div><small><small><?php echo __d('driver_profile', '<b>Envía un mensaje a %s</b> para comenzar a acordar tus recorridos con él.', $driver_name) ?></small></small></div>
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

$(window).scroll(function(){
        $("#fixed").css("top", Math.max(0, <?php echo $topPosition?> - $(this).scrollTop()));
});
</script>