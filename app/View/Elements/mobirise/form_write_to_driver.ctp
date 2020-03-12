<?php
$notificationType = DriverTravel::$NOTIFICATION_TYPE_DIRECT_MESSAGE;

$isDiscountOffer = isset($discount_id);
if($isDiscountOffer) $notificationType = DriverTravel::$NOTIFICATION_TYPE_DISCOUNT_OFFER_REQUEST;
$isActivityOffer = isset($offer_id);
if($isActivityOffer) $notificationType = DriverTravel::$NOTIFICATION_TYPE_ACTIVITY_OFFER_REQUEST;
?>
<?php echo $this->Session->flash();?>
<?php echo $this->Form->create('User', array('id' => 'CDirectForm', 'url' => array('controller' => 'users',  'action'=>'contact_driver'))); ?>
    <?php
    echo $this->Form->input('DriverTravel.driver_id', array('type' => 'hidden', 'value' => $profile['Driver']['id']));
    
    echo $this->Form->input('DriverTravel.last_driver_email', array('type' => 'hidden', 'value' => $profile['Driver']['username']));
    
    //Para el caso de envio de mensaje directo en conversacion expirada
    if(isset($expired)) echo "<input type='hidden' name='closed' id='closed' value='".$super."'>";
    
    if($isDiscountOffer) echo $this->Form->input('DriverTravel.discount_id', array('type' =>'hidden', 'value'=>$discount_id));
    /*Para si es una actividad de paseo*/
    if($isActivityOffer) echo $this->Form->input('offer_id', array('type' =>'hidden', 'value'=>$offer_id));
    /*----------------------------------*/
    echo $this->Form->input('DriverTravel.notification_type', array('type' => 'hidden', 'value' => $notificationType));
    
    echo $this->Form->custom_date('DriverTravel.travel_date', array('label' => __('Fecha inicial del viaje'), 'dateFormat' => 'dd/mm/yyyy', 'class'=>'input-sm'));
    
    echo $this->Form->input('DriverTravelerConversation.response_text', array('label' => __('Mensaje a %s sobre lo que quieres hacer', Driver::shortenName($profile['DriverProfile']['driver_name'])), 'type' => 'textarea', 'required' => 'required',
                                    'placeholder' => __d('mobirise/driver_profile', 'Hola %s', Driver::shortenName($profile['DriverProfile']['driver_name'])).' ...'));
    ?>

    <?php if(!$userLoggedIn):?>

        <div class="row row-sm-offset">
            <div class="col-md-6 multi-horizontal" data-for="name">
                <?php echo $this->Form->input("User.username", array("label" => __("Tu correo electrónico"), "type" => "email"));?>
            </div>
            <!-- Eliminado en la variante actual, lo dejo para futuro si acaso
            <div class="col-md-6 multi-horizontal" data-for="email">
                <?php echo $this->Form->input("User.password", array("label"=> __("Contraseña")));?>
            </div>
            -->
        </div>
        <?php echo $this->Form->input('User.lang', array('type' => 'hidden', 'value'=>  Configure::read('Config.language')));?>

    <?php endif;?>

    <br>
    <span class="input-group-btn">
        <input type="submit" class="btn btn-primary btn-form btn-block display-5" id="CDirectSubmit" 
               value="<?php echo __d('mobirise/driver_profile', 'Enviar este mensaje a %s', Driver::shortenName($profile['DriverProfile']['driver_name']))?>"> 

    </span>

<?php echo $this->Form->end(); ?>