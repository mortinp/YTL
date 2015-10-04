<?php App::uses('CakeTime', 'Utility')?>
<?php App::uses('Travel', 'Model')?>

<?php
//print_r($this->Time->listTimezones()) ;

// INIT
if (!isset($actions)) $actions = true;

$months_es = array(__('Enero'), __('Febrero'), __('Marzo'), __('Abril'), __('Mayo'), __('Junio'), __('Julio'), __('Agosto'), __('Septiembre'), __('Octubre'), __('Noviembre'), __('Diciembre'));
$days_es = array(__('Domingo'), __('Lunes'), __('Martes'), __('Miércoles'), __('Jueves'), __('Viernes'), __('Sábado'));

$personW = __('persona');
$pretty_people_count = $travel['PendingTravel']['people_count'].' ';
if($travel['PendingTravel']['people_count'] > 1) $pretty_people_count .= Inflector::pluralize ($personW);
else $pretty_people_count .= $personW;

$date_converted = strtotime($travel['PendingTravel']['date']);
$day = date('j', $date_converted);
$month = $months_es[date('n', $date_converted) - 1];
$day_of_week = $days_es[date('w', $date_converted)];
$year = date('Y', $date_converted);
$pretty_date = $day.' '.$month.', '.$year.' ('.$day_of_week.')';

$expired = CakeTime::isPast($date_converted) && !CakeTime::isToday($date_converted);

$hasPreferences = false;
foreach (Travel::getPreferences() as $key => $value) {
    if($travel['PendingTravel'][$key]) {
       $hasPreferences = true;
       break;
    }
}
?>

<legend>
    <b><span id='travel-locality-label'><?php echo $travel['PendingTravel']['origin']?></span></b> - <b><span id='travel-where-label'><?php echo $travel['PendingTravel']['destination']?></span></b>        
    <div style="display:inline-block"><small class="text-muted"><span id='travel-prettypeoplecount-label'><?php echo $pretty_people_count?></span></small></div>
</legend>
    
<p><b><?php echo __d('pending_travel', 'Fecha del Viaje')?>:</b> <span id='travel-date-label'><?php echo $pretty_date?></span></p>

<p><b><?php echo __d('pending_travel', 'Detalles del viaje')?>:</b> <span id='travel-details-label'><?php echo $travel['PendingTravel']['details']?></span></p>

<div id="preferences-place">
<?php if($hasPreferences):?>
    <p><b><?php echo __d('pending_travel', 'Preferencias')?>:</b>
        <span id='travel-preferences-label'>
        <?php
            $sep = '';
            foreach (Travel::getPreferences() as $key => $value) {
                if($travel['PendingTravel'][$key]) {
                    echo $sep.$value;
                    $sep = ', ';
                }
            }
         ?>
        </span>
    </p>
<?php endif?>
</div>

<p><b><?php echo __d('pending_travel', 'Tu correo electrónico')?>:</b> <span id='travel-email-label'><?php echo $travel['PendingTravel']['email']?></span></p>

<?php
$notice = array();
if($expired) {
    $notice['color'] = Travel::getStateSettings('E', 'color');
    $notice['label'] = Travel::getStateSettings('E', 'label');
    $notice['class'] = Travel::getStateSettings('E', 'class');
} else {
    $notice['color'] = Travel::getStateSettings($travel['PendingTravel']['state'], 'color');//Travel::$STATE[$travel['Travel']['state']]['color'];
    $notice['label'] = Travel::getStateSettings($travel['PendingTravel']['state'], 'label');//Travel::$STATE[$travel['Travel']['state']]['label'];
    $notice['class'] = Travel::getStateSettings($travel['PendingTravel']['state'], 'class');
}
?>
<div class="panel">
    <small>
        <span class="label <?php echo $notice['class']?>" style="display: inline-block;font-size: 10pt" title="<?php echo __('Este viaje está ').$notice['label']?>">
            <?php echo $notice['label']?>
        </span>
    </small>
</div>

<?php if($actions):?>
    <ul style="list-style-type: none;padding:0px">
        
        <?php if(!$expired):?>
        <li style="padding-right: 10px;display: inline-block">
        <?php echo $this->Html->link(
                '<i class="glyphicon glyphicon-eye-open"></i> Ver', 
                array('controller'=>'travels', 'action'=>'view/'.$travel['PendingTravel']['id']), 
                array('escape'=>false, 'class'=>'text-warning', 'title'=>'Ver este viaje'));?>
        </li>
        <?php endif?>
        
    
        <!--ADMIN ONLY-->
        <?php if(!Travel::isConfirmed($travel['PendingTravel']['state'])):?>
        
        <li style="padding-right: 10px;display: inline-block">
        <?php echo $this->Html->link(
            '<i class="glyphicon glyphicon-trash"></i> Eliminar', 
            array('controller'=>'travels', 'action'=>'delete/'.$travel['PendingTravel']['id']), 
                array('escape'=>false, 'class'=>'text-danger', 'title'=>'Eliminar este viaje', 'confirm'=>'¿Estás seguro que quieres eliminar este viaje?'));?>
        </li>
        
        <?php if(!$expired):?>
        <li style="padding-right: 10px;display: inline-block">
        <?php echo $this->Html->link(
            '<big><big><i class="glyphicon glyphicon-envelope"></i> <b>Confirmar</b></big></big>', 
            array('controller'=>'travels', 'action'=>'confirm/'.$travel['PendingTravel']['id']), 
                array('escape'=>false, 'title'=>'Confirmar y Enviar este viaje a los choferes'));?>
        </li>
        <?php endif?>
    <?php elseif(AuthComponent::user('role') === 'admin'):?>
        <li style="padding-right: 10px;display: inline-block">
        <?php echo $this->Html->link(
            '<i class="glyphicon glyphicon-trash"></i> Eliminar', 
            array('controller'=>'travels', 'action'=>'delete/'.$travel['PendingTravel']['id']), 
                array('escape'=>false, 'class'=>'text-danger', 'title'=>'Eliminar este viaje', 'confirm'=>'¿Estás seguro que quieres eliminar este viaje?'));?>
        </li>
    <?php endif?>
        
    </ul>
<?php endif?>