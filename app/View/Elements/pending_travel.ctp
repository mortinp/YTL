<?php App::uses('CakeTime', 'Utility')?>
<?php App::uses('Travel', 'Model')?>

<?php
//print_r($this->Time->listTimezones()) ;

// INIT
if (!isset($actions)) $actions = true;

$months_es = array(__('Enero'), __('Febrero'), __('Marzo'), __('Abril'), __('Mayo'), __('Junio'), __('Julio'), __('Agosto'), __('Septiembre'), __('Octubre'), __('Noviembre'), __('Diciembre'));
$days_es = array(__('Domingo'), __('Lunes'), __('Martes'), __('Miércoles'), __('Jueves'), __('Viernes'), __('Sábado'));

$pretty_people_count = $travel['PendingTravel']['people_count'].' '.__('persona');
if($travel['PendingTravel']['people_count'] > 1) $pretty_people_count .='s';

$date_converted = strtotime($travel['PendingTravel']['date']);
$day = date('j', $date_converted);
$month = $months_es[date('n', $date_converted) - 1];
$day_of_week = $days_es[date('w', $date_converted)];
$year = date('Y', $date_converted);
$pretty_date = $day.' '.$month.', '.$year.' ('.$day_of_week.')';
//$pretty_date = date('j F, Y (l)', strtotime($travel['PendingTravel']['date']));

$expired = CakeTime::isPast($date_converted) && !CakeTime::isToday($date_converted);

$hasPreferences = false;
foreach (Travel::$preferences as $key => $value) {
    if($travel['PendingTravel'][$key]) {
       $hasPreferences = true;
       break;
    }
}
?>

<?php
    $notice = array();
    if($expired) {
        $notice['color'] = Travel::$STATE['E']['color'];
        $notice['label'] = Travel::$STATE['E']['label'];
    } else {
        $notice['color'] = Travel::$STATE[$travel['PendingTravel']['state']]['color'];
        $notice['label'] = Travel::$STATE[$travel['PendingTravel']['state']]['label'];
    }
?>

<!--<?php if($expired) echo '<s>'?>-->

<legend>
   
    <small><i title="<?php echo $notice['label']?>" class="glyphicon glyphicon-flag" style="margin-left:-20px;color:<?php echo $notice['color']?>;display: inline-block"></i></small>
    
    <big>
        <span id='travel-locality-label'><?php echo $travel['PendingTravel']['origin']?></span> 
        - 
        <span id='travel-where-label'><?php echo $travel['PendingTravel']['destination']?></span>        
    </big> 
    <div style="display:inline-block"><small class="text-muted"><span id='travel-prettypeoplecount-label'><?php echo $pretty_people_count?></span></small></div>
    
    <!--<span><small style="color:<?php echo $notice['color']?>">(<?php echo $notice['label']?>)</small></span>-->
</legend>
    
<p><b><?php echo __('Día del viaje')?>:</b> <span id='travel-date-label'><?php echo $pretty_date?></span></p>

<div id="preferences-place">
<?php if($hasPreferences):?>
    <p><b><?php echo __('Preferencias')?>:</b>
        <span id='travel-preferences-label'>
        <?php
            $sep = '';
            foreach (Travel::$preferences as $key => $value) {
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

<p><b><?php echo __('Información de Contacto')?>:</b> <span id='travel-contact-label'><?php echo $travel['PendingTravel']['contact']?></span></p>

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

<!--<?php if($expired) echo '</s>'?>-->