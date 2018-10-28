<?php echo $this->Session->flash(); ?>
<?php echo $this->Form->create('User', array('id' => 'CDirectForm', 'url' => array('controller' => 'users',  'action'=>'contact_driver'))); ?>
    <?php
    echo $this->Form->input('DriverTravel.driver_id', array('type' => 'hidden', 'value' => $profile['Driver']['id']));
    echo $this->Form->input('DriverTravel.notification_type', array('type' => 'hidden', 'value' => DriverTravel::$NOTIFICATION_TYPE_DIRECT_MESSAGE));
    echo $this->Form->input('DriverTravel.last_driver_email', array('type' => 'hidden', 'value' => $profile['Driver']['username']));
    ?>
        
    <?php echo $this->Form->custom_date('DriverTravel.travel_date', array('label' => __('Fecha inicial del viaje'), 'dateFormat' => 'dd/mm/yyyy', 'class'=>'input-sm'));?>
    
    <?php
    echo $this->Form->input('DriverTravelerConversation.response_text', array('label' => __('Mensaje a %s sobre lo que quieres hacer', Driver::shortenName($profile['DriverProfile']['driver_name'])), 'type' => 'textarea', 'required' => 'required',
                                    'placeholder' => __d('mobirise/driver_profile', 'Hola %s', Driver::shortenName($profile['DriverProfile']['driver_name'])).' ...'));        
    ?>

    <?php if(!$userLoggedIn):?>

        <div class="row row-sm-offset">
            <div class="col-md-6 multi-horizontal" data-for="name">
                <?php echo $this->Form->input("User.username", array("label" => __("Tu correo electrónico"), "type" => "email"));?>
            </div>
            <div class="col-md-6 multi-horizontal" data-for="email">
                <?php echo $this->Form->input("User.password", array("label"=> __("Contraseña")));?>
            </div>
        </div>
        <?php echo $this->Form->input('User.lang', array('type' => 'hidden', 'value'=>  Configure::read('Config.language')));?>

    <?php endif;?>

    <br>
    <span class="input-group-btn">
        <input type="submit" class="btn btn-primary btn-form display-5" id="CDirectSubmit" 
               value="<?php echo __d('mobirise/driver_profile', 'Enviar este mensaje a %s', Driver::shortenName($profile['DriverProfile']['driver_name']))?>. <?php echo __d('mobirise/driver_profile', 'Recibe una oferta y empieza a acordar tu viaje')?>"> 

    </span>

<?php echo $this->Form->end(); ?>