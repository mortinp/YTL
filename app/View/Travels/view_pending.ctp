<?php
App::uses('Auth', 'Component');
?>

<div class="container">
    <div class="row">
        <div class="col-md-5" style="margin-bottom: 20px">

            <div id="travel">
                <p>
                    <?php echo __d('pending_travel', 'El siguiente viaje está')?>
                    <span style="color:<?php echo Travel::getStateSettings($travel['PendingTravel']['state'], 'color')?>">
                        <b><?php echo Travel::getStateSettings($travel['PendingTravel']['state'], 'label')?></b>
                    </span>:
                </p>
                <?php echo $this->element('pending_travel', array('actions'=>false))?>
                <a title="<?php echo __d('pending_travel', 'Editar este Viaje')?>" href="#!" class="edit-travel">&ndash; <?php echo __d('pending_travel', 'Editar este Viaje')?></a>
            </div>
            <div id='travel-form' style="display:none">
                <legend><?php echo __d('pending_travel', 'Edita los datos de este viaje antes de confirmarlo')?> <div><a href="#!" class="cancel-edit-travel">&ndash; <?php echo __d('pending_travel', 'no editar este viaje')?></a></div></legend>
                <?php echo $this->element('pending_travel_form', array('do_ajax' => true, 'form_action' => 'edit_pending', 'intent'=>'edit')); ?>
                <br/>
            </div>
        </div>
        
        <div class="col-md-6 col-md-offset-1 well" style="background-color: lightgoldenrodyellow"> 
            <div >
                <p><?php echo __d('pending_travel', 'Un gran viaje hasta <em>%s</em> está esperando por tí', $travel['PendingTravel']['destination'])?>.</p>
                <p><big><big><b><?php echo __d('pending_travel', 'Regístrate para confirmar este viaje')?></b></big></big></p>
            </div>
            <?php echo $this->Form->create('User', array('controller' => 'users', 'action' => 'register_and_create/'.$travel['PendingTravel']['id'])); ?>
            <fieldset>
                <?php
                echo $this->Form->input('fake_username', array('label' => __d('pending_travel', 'Tu correo electrónico'), 'value'=>$travel['PendingTravel']['email'], 'type' => 'email', 'disabled'=>true));
                echo $this->Form->input('username', array('label' => __d('pending_travel', 'Tu correo electrónico'), 'value'=>$travel['PendingTravel']['email'], 'type' => 'hidden'));
                echo $this->Form->input('password', array('label'=> __d('pending_travel', 'Crea una contraseña para tu cuenta'), 'placeholder'=>__d('pending_travel', 'Escribe la contraseña que usarás para YoTeLlevo'), 'autofocus'));
                echo $this->Form->checkbox('remember_me').' '.__d('pending_travel', 'Recordarme');
                
                echo $this->Form->input('lang', array('type' => 'hidden', 'value'=>  Configure::read('Config.language')));
                ?>
                <br/>
                <br/>
                <div style="text-align: center">
                    <?php echo $this->Form->submit(__d('pending_travel', "Registrarme y Confirmar este Anuncio de Viaje <div style='font-size:11pt;padding-left:50px;padding-right:50px'>Contacta con <big>3</big> choferes ahora</div>"), array('style'=>'font-size:14pt;white-space: normal;', 'escape'=>false), true);?>
                </div>
            </fieldset>
            <?php echo $this->Form->end(); ?>
            <br/>
            <p>* <?php echo __d('pending_travel', 'Podrás gestionar tus viajes en cualquier momento usando este usuario y contraseña')?>.</p>
        </div>
    </div>
    <!--<br/>
    <br/>
    <div class="row">
        <div class="col-md-2"><h3>Libre de riesgo</h3>
            <p>
                Rechaza las ofertas de los choferes en cualquer momento.
            </p>
        </div>
        <div class="col-md-2 col-md-offset-3"><h3>Privado</h3>
            <p>
                Habla con cada chofer de forma privada via email.
            </p>
        </div>
        <div class="col-md-2 col-md-offset-3"><h3>Flexible</h3>
            <p>
                Acuerda todo según tus necesidades. No hay precios ni itinerarios fijos.
            </p>
        </div>
    </div>-->
</div>

<?php
$this->Html->script('jquery', array('inline' => false));
    
$this->Js->set('travel', $travel);
$this->Js->set('travels_preferences', Travel::getPreferences());
$this->Js->set('localities', $localities);
echo $this->Js->writeBuffer(array('inline' => false));
?>

<?php echo $this->Html->script('travels_view', array('inline' => false));?>