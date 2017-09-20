<?php echo $this->Form->create('User', array('id' => 'CDirectForm', 'url' => array('controller' => 'users',  'action'=>'contact_driver'))); ?>
<fieldset>
    <div class="col-md-12">
        <?php if(!$userLoggedIn):?><div class="col-md-6"><?php endif?>
            <?php
            echo $this->Form->input('DriverTravel.driver_id', array('type' => 'hidden', 'value' => $profile['Driver']['id']));
            echo $this->Form->input('DriverTravel.notification_type', array('type' => 'hidden', 'value' => DriverTravel::$NOTIFICATION_TYPE_DIRECT_MESSAGE));
            echo $this->Form->input('DriverTravel.last_driver_email', array('type' => 'hidden', 'value' => $profile['Driver']['username']));
            echo $this->Form->custom_date('DriverTravel.travel_date', array('label' => __('Fecha inicial del viaje'), 'dateFormat' => 'dd/mm/yyyy', 'class'=>'input-sm'));

            echo $this->Form->input('DriverTravelerConversation.response_text', array('label' => __('Detalles del viaje'), 'type' => 'textarea',
                                    'placeholder' => __('Cualquier detalle que quieras explicarle a %s', Driver::shortenName($profile['DriverProfile']['driver_name'])), 'required' => 'required'));        
            ?>
        <?php if(!$userLoggedIn):?></div><?php endif?>
        <?php if(!$userLoggedIn):?><div class="col-md-6"><?php endif?>
            <?php
            if(!$userLoggedIn){                     
                echo $this->Form->input("User.username", array("label" => __("Tu correo electrónico"), "type" => "email"));
                echo $this->Form->input("User.password", array("label"=> __("Contraseña")));
                echo $this->Form->input('User.lang', array('type' => 'hidden', 'value'=>  Configure::read('Config.language')));
            }
            ?>
        <?php if(!$userLoggedIn):?></div><?php endif?>
    </div>
    <div class="submit col-md-<?php if($userLoggedIn) echo '12';else echo '6 col-md-offset-3'?>" style="text-align: center">
        <?php
        $saveButtonText = __d('driver_profile', 'Enviar el mensaje ahora').' <div style="font-size:12pt;padding-left:50px;padding-right:50px">'.__d('driver_profile', 'Recibe una oferta de precio de %s y comienza a acordar los detalles de tu viaje', $profile['DriverProfile']['driver_name']).'</div>';
        $buttonStyle = 'font-size:18pt;white-space: normal;';
        echo $this->Form->submit($saveButtonText, array('style' => $buttonStyle, 'id' => 'CDirectSubmit', 'class'=>'btn btn-block btn-info', 'escape'=>false, 'rel'=>'nofollow'), true);
        ?>
    </div>
</fieldset>
<?php echo $this->Form->end(); ?>

<?php echo $this->element('addon_scripts_send_form', array('formId'=>'CDirectForm', 'submitId'=>'CDirectSubmit'))?>

<?php
    $this->Html->css('vitalets-bootstrap-datepicker/datepicker.min', array('inline' => false));
    $this->Html->script('jquery', array('inline' => false));
    $this->Html->script('vitalets-bootstrap-datepicker/bootstrap-datepicker.min', array('inline' => false));
?>

<script type="text/javascript">
    $(document).ready(function(){
        $('.datepicker').datepicker({
            format: "dd/mm/yyyy",
            language: '<?php echo Configure::read('Config.language')?>',
            startDate: 'today',
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        });
    });
</script>