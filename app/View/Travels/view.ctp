<?php
App::uses('Auth', 'Component');
App::uses('Locality', 'Model');

$isConfirmed = Travel::isConfirmed($travel['Travel']['state']);

if($isConfirmed) {
    $drivers_sent_count = $travel['Travel']['drivers_sent_count'];
    if($drivers_sent_count > 5) $drivers_sent_count = 5; // HACK: esto es para que no se vea que se le mando el viaje a mas de 5 choferes
    
    $driverW = __('chofer');
    $pretty_drivers_count = $drivers_sent_count.' ';
    if($drivers_sent_count > 1) {
        if(Configure::read('Config.language') == 'es') $pretty_drivers_count .= 'choferes';
        else $pretty_drivers_count .= Inflector::pluralize($driverW);
    }
    else $pretty_drivers_count .= $driverW;
}
?>

<div class="container">
<div class="row">
    <div class="col-md-8 col-md-offset-2"> 
        <div id="travel">
            <?php echo __('Estos son los detalles de tu viaje')?>:
            <br/>
            <br/>
            <?php echo $this->element('travel', array('actions'=>false))?>
            
            <?php if(!$isConfirmed):?>
                <a title="<?php echo __('Cambiar datos de la solicitud antes de enviarla a los choferes')?>" href="#!" class="edit-travel info">&ndash; <?php echo __('Editar esta solicitud')?></a>    
                <br/>
                <br/>
                <?php echo $this->Html->link(__('Confirmar este Anuncio de Viaje').' 
                <div style="font-size:10pt;padding-left:50px;padding-right:50px">'.__('Acuerda enseguida los detalles del viaje con tu chofer').'</div>', 
                    array('controller'=>'travels', 'action'=>'confirm/'.$travel['Travel']['id']), 
                    array('class'=>'btn btn-primary', 'style'=>'font-size:16pt;white-space: normal;', 'escape'=>false));?>
            <?php else:?>   
                <br/>
                
                <span class="alert alert-info" style="display: inline-block">
                    <ul class="text-info" style="list-style-type: none;padding: 0px;font-weight: bold">
                        <li style="margin-bottom: 15px">
                            <i class="glyphicon glyphicon-hand-right" style="margin-right:10px"></i> <span><?php echo __('%s ya recibieron los detalles de este viaje', '<code><big>'.$pretty_drivers_count.'</big></code>').'.'?></span>
                        </li>

                        <li>
                            <i class="glyphicon glyphicon-envelope" style="margin-right:10px"></i> <?php echo __('Los mensajes de los choferes llegarán a tu correo %s', '<code><big>'.$travel['User']['username'].'</big></code>').'. '.__('También puedes verlos desde el botón %s en el menú de arriba', '<span class="label label-success">'.__('Mis Mensajes').'</span>').'.'?>
                        </li>
                    </ul>
                </span>  
                
                <br/>
                <?php echo $this->Html->link('<div class="btn btn-default"><big>&laquo;	'.__('Ver todas mis solicitudes').'</big></div>', array('controller'=>'travels', 'action'=>'index'), array('escape'=>false))?>
            <?php endif?>
        </div>
        <?php if(!$isConfirmed):?>
            <div id='travel-form' style="display:none">
                <legend><?php echo __('Edita los datos de este viaje antes de confirmarlo')?> <div><a href="#!" class="cancel-edit-travel">&ndash; <?php echo __('no editar este viaje')?></a></div></legend>
                <?php echo $this->element('travel_form', array('do_ajax' => true, 'form_action' => 'edit/' . $travel['Travel']['id'], 'intent'=>'edit')); ?>
                <br/>
            </div>
        <?php endif?>    
        
    </div>    
</div>
</div>

<?php
$this->Html->script('jquery', array('inline' => false));
    
$this->Js->set('travel', $travel);
$this->Js->set('travels_preferences', Travel::getPreferences());
$this->Js->set('localities', Locality::getAsSuggestions());
$this->Js->set('lang', SessionComponent::read('app.lang'));
echo $this->Js->writeBuffer(array('inline' => false));
?>

<?php if(!$isConfirmed):?>
    <?php echo $this->Html->script('travels_view', array('inline' => false));?>
<?php endif?>