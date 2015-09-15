<?php
App::uses('Auth', 'Component');

$isConfirmed = Travel::isConfirmed($travel['Travel']['state']);

if($isConfirmed) {
    
    $driverW = __('chofer');
    $pretty_drivers_count = $travel['Travel']['drivers_sent_count'].' ';
    if($travel['Travel']['drivers_sent_count'] > 1) {
        if(Configure::read('Config.language') == 'es') $pretty_drivers_count .= 'choferes';
        else $pretty_drivers_count .= Inflector::pluralize($driverW);
    }
    else $pretty_drivers_count .= $driverW;
}
?>

<div class="container">
<div class="row">
    <div class="col-md-6 col-md-offset-3"> 
        <div id="travel">
            <p>
                <?php echo __('El siguiente viaje está')?>
                <span style="color:<?php echo Travel::getStateSettings($travel['Travel']['state'], 'color')?>">
                    <b><?php echo Travel::getStateSettings($travel['Travel']['state'], 'label')?></b>
                </span>:
            </p>
            <?php echo $this->element('travel', array('actions'=>false))?>
            <?php if(!$isConfirmed):?>
                <a title="<?php echo __('Editar este Viaje')?>" href="#!" class="edit-travel">&ndash; <?php echo __('Editar este Viaje')?></a>    
                <br/>
                <br/>
                <?php echo $this->Html->link(__('Confirmar este Anuncio de Viaje').' 
                <div style="font-size:10pt;padding-left:50px;padding-right:50px">'.__('Acuerda enseguida los detalles del viaje con tu chofer').'</div>', 
                    array('controller'=>'travels', 'action'=>'confirm/'.$travel['Travel']['id']), 
                    array('class'=>'btn btn-primary', 'style'=>'font-size:16pt;white-space: normal;', 'escape'=>false));?>
            <?php else:?>   
                <br/>
                <p class="text-info">
                    <?php if(AuthComponent::user('role') == 'regular'):?>
                    <b><?php echo __('Los datos de este viaje fueron eviados a <big>%s</big>. Pronto recibirás las ofertas.', $pretty_drivers_count)?></b>

                    <?php else:?>
                    <b>Se encontaron <big><?php echo $pretty_drivers_count?></big></b> para notificar, pero son <b>choferes de prueba</b> porque eres un usuario <b><?php echo AuthComponent::user('role')?></b>.
                    <?php endif?>
                </p>
            <?php endif?>
        </div>
        <?php if(!$isConfirmed):?>
            <div id='travel-form' style="display:none">
                <legend><?php echo __('Edita los datos de este viaje antes de confirmarlo')?> <div><a href="#!" class="cancel-edit-travel">&ndash; <?php echo __('no editar este viaje')?></a></div></legend>
                <?php echo $this->element('travel_form', array('do_ajax' => true, 'form_action' => 'edit/' . $travel['Travel']['id'], 'intent'=>'edit')); ?>
                <br/>
            </div>
        <?php endif?>
        
        <br/>
        <?php echo $this->Html->link('<div class="btn btn-success"><big>'.__('Ver todos mis anuncios de viajes').'</big></div>', array('controller'=>'travels', 'action'=>'index'), array('escape'=>false))?>
    </div>    
</div>
</div>

<?php
$this->Html->script('jquery', array('inline' => false));
    
$this->Js->set('travel', $travel);
$this->Js->set('travels_preferences', Travel::getPreferences());
$this->Js->set('localities', $localities);
$this->Js->set('lang', SessionComponent::read('app.lang'));
echo $this->Js->writeBuffer(array('inline' => false));
?>

<?php if(!$isConfirmed):?>
    <?php echo $this->Html->script('travels_view', array('inline' => false));?>
<?php endif?>