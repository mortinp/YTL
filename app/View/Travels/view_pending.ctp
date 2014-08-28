<?php
App::uses('Auth', 'Component');
?>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            <div id="travel">
                <p>
                    <?php echo __('Tienes el siguiente viaje')?>
                    <span style="color:<?php echo Travel::$STATE[$travel['PendingTravel']['state']]['color']?>">
                        <b><?php echo Travel::$STATE[$travel['PendingTravel']['state']]['label']?></b>
                    </span>:
                </p>
                <?php echo $this->element('pending_travel', array('actions'=>false))?>
                <a title="<?php echo __('Editar este Viaje')?>" href="#!" class="edit-travel">&ndash; <?php echo __('Editar este Viaje')?></a>
            </div>
            <div id='travel-form' style="display:none">
                <legend><?php echo __('Edita los datos de este viaje antes de confirmarlo')?> <div><a href="#!" class="cancel-edit-travel">&ndash; <?php echo __('no editar este viaje')?></a></div></legend>
                <?php echo $this->element('pending_travel_form', array('do_ajax' => true, 'form_action' => 'edit_pending', 'intent'=>'edit')); ?>
                <br/>
            </div>
            
            <br/>
            <br/>
            <div class="alert alert-info">
                <div >
                    <!--<p><?php echo __('<b>Estás a sólo un paso</b> de que los choferes puedan contactarte para acordar los términos del viaje')?>.</p>-->
        
                    <p>
                    <?php echo __('<big><big><b>Regístrate para confirmar este viaje</b></big></big> <span>&mdash; Podrás gestionar tus viajes en cualquier momento y acceder a todas las funcionalidades de <em>YoTeLlevo</em></span>')?>                        
                    </p>
                </div>
                <?php echo $this->Form->create('User', array('controller' => 'users', 'action' => 'register_and_create/'.$travel['PendingTravel']['id'])); ?>
                <fieldset>
                    <?php
                    echo $this->Form->input('fake_username', array('label' => __('Tu correo electrónico'), 'value'=>$travel['PendingTravel']['email'], 'type' => 'email', 'disabled'=>true));
                    echo $this->Form->input('username', array('label' => __('Tu correo electrónico'), 'value'=>$travel['PendingTravel']['email'], 'type' => 'hidden'));
                    echo $this->Form->input('password', array('label'=> __('Crea una contraseña para tu cuenta'), 'placeholder'=>__('Escribe la contraseña que usarás para YoTeLlevo'), 'autofocus'));
                    echo $this->Form->checkbox('remember_me').' '.__('Recordarme');
                    echo $this->Form->submit(__('Registrarme y Confirmar este Anuncio de Viaje'));
                    ?>
                </fieldset>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

<?php
$this->Html->script('jquery', array('inline' => false));
    
$this->Js->set('travel', $travel);
$this->Js->set('travels_preferences', Travel::$preferences);
$this->Js->set('localities', $localities);
echo $this->Js->writeBuffer(array('inline' => false));
?>

<?php echo $this->Html->script('travels_view', array('inline' => false));?>