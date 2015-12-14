<?php App::uses('CakeTime', 'Utility')?>
<?php App::uses('Travel', 'Model')?>
<?php App::uses('DriverTravelerConversation', 'Model')?>

<?php
// INIT
if (!isset($actions)) $actions = true;
if (!isset($details)) $details = false;
if (!isset($showConversations)) $showConversations = true;
if (!isset($embedEmail)) $embedEmail = false;

$personW = __('persona');
$pretty_people_count = $travel['Travel']['people_count']. ' ';
if($travel['Travel']['people_count'] > 1) $pretty_people_count .= Inflector::pluralize ($personW);
else $pretty_people_count .= $personW;

$months_es = array(__('Enero'), __('Febrero'), __('Marzo'), __('Abril'), __('Mayo'), __('Junio'), __('Julio'), __('Agosto'), __('Septiembre'), __('Octubre'), __('Noviembre'), __('Diciembre'));
$days_es = array(__('Domingo'), __('Lunes'), __('Martes'), __('Miércoles'), __('Jueves'), __('Viernes'), __('Sábado'));

$date_converted = strtotime($travel['Travel']['date']);
$day = date('j', $date_converted);
$month = $months_es[date('n', $date_converted) - 1];
$day_of_week = $days_es[date('w', $date_converted)];
$year = date('Y', $date_converted);
$pretty_date = $day.' '.$month.', '.$year.' ('.$day_of_week.')';
//$pretty_date = date('j F, Y (l)', strtotime($travel['Travel']['date']));

$expired = CakeTime::isPast($date_converted) && !CakeTime::isToday($date_converted);

$hasPreferences = false;
foreach (Travel::getPreferences() as $key => $value) {
    if($travel['Travel'][$key]) {
       $hasPreferences = true;
       break;
    }
}
?>

<?php
    $notice = array();
    if($expired) {
        $notice['color'] = Travel::getStateSettings('E', 'color');
        $notice['label'] = Travel::getStateSettings('E', 'label');
        $notice['class'] = Travel::getStateSettings('E', 'class');
    } else {
        $notice['color'] = Travel::getStateSettings($travel['Travel']['state'], 'color');//Travel::$STATE[$travel['Travel']['state']]['color'];
        $notice['label'] = Travel::getStateSettings($travel['Travel']['state'], 'label');//Travel::$STATE[$travel['Travel']['state']]['label'];
        $notice['class'] = Travel::getStateSettings($travel['Travel']['state'], 'class');
    }
?>
<legend>
    <b><span id='travel-locality-label'><?php echo $travel['Travel']['origin']?></span></b> - <b><span id='travel-where-label'><?php echo $travel['Travel']['destination']?></span></b>
    <div style="display:inline-block"><small class="text-muted"><span id='travel-prettypeoplecount-label'><?php echo $pretty_people_count?></span></small></div>
</legend>
    
<p><b><?php echo __('Fecha del viaje')?>:</b> <span id='travel-date-label'><?php echo $pretty_date?></span></p>

<p><b><?php echo __('Detalles del viaje')?>:</b> <span id='travel-details-label'><?php if($embedEmail) echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $travel['Travel']['details']); else echo $travel['Travel']['details']?></span></p>

<?php if(!Configure::read('conversations_via_app')):?>
<p><b><?php echo __('Correo de contacto')?>:</b> <span id='travel-details-label'><?php echo $travel['User']['username']?></span></p>
<?php endif?>

<div id="preferences-place">
<?php if($hasPreferences):?>
    <p><b><?php echo __('Preferencias')?>:</b>
        <span id='travel-preferences-label'>
        <?php
            $sep = '';
            foreach (Travel::getPreferences() as $key => $value) {
                if($travel['Travel'][$key]) {
                    echo $sep.$value;
                    $sep = ', ';
                }
            }
         ?>
        </span>
    </p>
<?php endif?>
</div>

<?php if(!$embedEmail):?>
<div class="panel">
    <small>
        <span class="label <?php echo $notice['class']?>" style="display: inline-block;font-size: 10pt" title="<?php echo __('Este viaje está ').$notice['label']?>">
            <?php echo $notice['label']?>
        </span>
    </small>
</div>
<?php endif;?>


<?php if($details):?>
    <hr/>
    <p><b>ID:</b> <?php echo $travel['Travel']['id']?></p>
    <p><b>Creado por:</b> 
    <?php 
    $created_converted = strtotime($travel['Travel']['created']);
    $now = new DateTime(date('Y-m-d', time()));
    $daysPosted = $now->diff(new DateTime($travel['Travel']['created']), true)->format('%a');
    if(isset ($travel['User']))
        echo $travel['User']['username'];
    else if(isset ($travel['Travel']['User']))
        echo $travel['Travel']['User']['username'];
    echo ' - <b>Fecha creación:</b> '.date('d-m-Y', $created_converted).' <span class="text-muted">(hace '.$daysPosted.' días)</span>';
    ?>
    </p>
    <?php if(isset ($travel['DriverTravel']) && $showConversations):?>
    <p><b>Conversaciones:</b>
    <ul id="conversations-travel-<?php echo $travel['Travel']['id']?>" style="list-style-type:none">
        <?php foreach ($travel['DriverTravel'] as $sent) :?>
        <li><?php echo $this->element('conversation_id_decorated', array('conversation'=>$sent))?></li>
        <?php endforeach; ?>
            
        <?php if(isset($drivers)):?>
            <li>
                <span id="notify-driver-travel-set-<?php echo $travel['Travel']['id']?>" style="display: inline-block">
                    <a href="#!" class="edit-notify-driver-travel-<?php echo $travel['Travel']['id']?>">&ndash; <?php echo __('Notificar a otro chofer')?></a>
                </span>
                <span id="notify-driver-travel-cancel-<?php echo $travel['Travel']['id']?>" style="display:none">
                    <a href="#!" class="cancel-edit-notify-driver-travel-<?php echo $travel['Travel']['id']?>">&ndash; <?php echo __('Cancelar')?></a>
                </span>
                <div id='notify-driver-travel-form-<?php echo $travel['Travel']['id']?>' style="display:none">
                    <br/>                    
                    <?php echo $this->element('form_notify_driver', array('drivers'=>$drivers, 'travel_id'=>$travel['Travel']['id']))?>
                </div>
            </li>

            <script type="text/javascript">
                $('.edit-notify-driver-travel-<?php echo $travel['Travel']['id']?>, .cancel-edit-notify-driver-travel-<?php echo $travel['Travel']['id']?>').click(function() {
                    $('#notify-driver-travel-form-<?php echo $travel['Travel']['id']?>, #notify-driver-travel-set-<?php echo $travel['Travel']['id']?>, #notify-driver-travel-cancel-<?php echo $travel['Travel']['id']?>').toggle();
                });
            </script>
        <?php endif?>
            
            
        </ul>
    </p>
    <?php endif?>
    
<?php endif?>

<?php if($actions):?>
    <ul style="list-style-type: none;padding:0px">
        
        <?php if(!$expired):?>
        <li style="padding-right: 10px;display: inline-block">
        <?php echo $this->Html->link(
                /*'<i class="glyphicon glyphicon-eye-open"></i> '.*/__('Ver').' »', 
                array('controller'=>'travels', 'action'=>'view/'.$travel['Travel']['id']), 
                array('escape'=>false, 'class'=>'text-warning', 'title'=>__('Ver detalles de este viaje')));?>
        </li>
        <?php endif?>
        
    <?php if(!Travel::isConfirmed($travel['Travel']['state'])):?>
        
        <li style="padding-right: 10px;display: inline-block">
        <?php echo $this->Html->link(
            '<i class="glyphicon glyphicon-trash"></i> '.__('Eliminar'), 
            array('controller'=>'travels', 'action'=>'delete/'.$travel['Travel']['id']), 
                array('escape'=>false, 'class'=>'text-danger', 'title'=>__('Eliminar este viaje'), 'confirm'=>__('¿Estás seguro que quieres eliminar este viaje?')));?>
        </li>
        
        <?php if(!$expired):?>
        <li style="padding-right: 10px;display: inline-block">
        <?php echo $this->Html->link(
            '<i class="glyphicon glyphicon-share-alt"></i> <b>'.__('Confirmar').'</b>',
            array('controller'=>'travels', 'action'=>'confirm/'.$travel['Travel']['id']), 
                array('escape'=>false, 'title'=>__('Confirmar y Enviar este viaje a los choferes')));?>
        </li>
        <?php endif?>
    <?php elseif(AuthComponent::user('role') === 'admin'):?>
        <li style="padding-right: 10px;display: inline-block">
        <?php echo $this->Html->link(
            '<i class="glyphicon glyphicon-trash"></i> '.__('Eliminar'), 
            array('controller'=>'travels', 'action'=>'delete/'.$travel['Travel']['id']), 
                array('escape'=>false, 'class'=>'text-danger', 'title'=>__('Eliminar este viaje'), 'confirm'=>__('¿Estás seguro que quieres eliminar este viaje?')));?>
        </li>
    <?php endif?>
        
    </ul>
<?php endif?>