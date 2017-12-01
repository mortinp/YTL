<?php App::uses('CakeTime', 'Utility')?>
<?php App::uses('TimeUtil', 'Util')?>
<?php App::uses('Travel', 'Model')?>
<?php App::uses('DriverTravelerConversation', 'Model')?>

<?php
// INIT
if (!isset($actions)) $actions = true;
if (!isset($details)) $details = false;
if (!isset($showConversations)) $showConversations = true;
if (!isset($embedEmail)) $embedEmail = false;
if (!isset($changeDate)) $changeDate = false;
if (!isset($showMoreUserRequests)) $showMoreUserRequests = false;

$personW = __('persona');
$pretty_people_count = $travel['Travel']['people_count']. ' ';
if($travel['Travel']['people_count'] > 1) $pretty_people_count .= Inflector::pluralize ($personW);
else $pretty_people_count .= $personW;

$expired = $travel['Travel']['is_expired'];

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
        $notice['color'] = Travel::getStateSettings($travel['Travel']['state'], 'color');
        $notice['label'] = Travel::getStateSettings($travel['Travel']['state'], 'label');
        $notice['class'] = Travel::getStateSettings($travel['Travel']['state'], 'class');
    }
?>

<div id="travel-<?php echo $travel['Travel']['id']?>">
<?php if($details):?>
    <?php 
    $created_converted = strtotime($travel['Travel']['created']);
    $now = new DateTime(date('Y-m-d', time()));
    $daysPosted = $now->diff(new DateTime($travel['Travel']['created']), true)->format('%a');
    if(isset ($travel['User'])) $user = $travel['User'];
    else if(isset ($travel['Travel']['User'])) $user = $travel['Travel']['User'];
    ?>
    
    <!-- DATOS PARA OPERADORES -->
    <div>
        <!-- DATOS DEL USUARIO Y OTROS DATOS IMPORTANTES -->
        <div>
            <span><span class="text-muted">#</span><big><big><?php echo $travel['Travel']['id']?></big></big></span>
            &nbsp;<i class="glyphicon glyphicon-user text-muted"></i>
            <?php echo $user['username'];?> <span class="text-muted">hace </span><?php echo $daysPosted?> <span class="text-muted">días</span>
            
            <?php if($userLoggedIn && $userRole == 'admin'):?>
                <?php if(isset($user['shared_ride_offered']) && $user['shared_ride_offered']):?>
                    <span class="label label-primary">Enviada solicitud compartidos</span>
                <?php elseif(in_array($travel['Travel']['people_count'], array(2, 3))):?>
                    <span class="label label-success">Compartido?</span>
                <?php endif;?>
            <?php endif;?>
                
            <?php $op = isset ($travel['Operator'])? $travel['Operator']: (isset ($travel['Travel']['Operator'])? $travel['Travel']['Operator']:null)?>
            <?php if($op):?><div class="info pull-right" title="Operador que atiende este viaje: <?php echo $op['display_name']?>"><span class="text-muted">Op: </span> <big><code><?php echo $op['display_name']?></code></big></div><?php endif?>
        </div>
        
        <!-- LINK PARA VER TODAS LAS SOLICTUDES DE ESTE USUARIO -->
        <?php if($showMoreUserRequests):?>
            <div><?php echo $this->Html->link($user['travel_count'].' solicitudes »', array('controller'=>'users', 'action'=>'view_travels/'.$user['id']), array('target'=>'_blank'));?></div>
        <?php endif?>
    </div>
    <br/>
<?php endif?>
    
<legend>
    <b><span id='travel-locality-label'><?php echo $travel['Travel']['origin']?></span></b> - <b><span id='travel-where-label'><?php echo $travel['Travel']['destination']?></span></b>
    <div style="display:inline-block"><small class="text-muted"><span id='travel-prettypeoplecount-label'><?php echo $pretty_people_count?></span></small></div>
</legend>
    
<p> 
    <?php $fechaCambiada = isset ($travel['Travel']['original_date']) && $travel['Travel']['original_date'] != null;?>
    <?php if($fechaCambiada):?>
    <span class="badge">
    <b><?php echo __('Fecha original')?>:</b> 
    <span id='travel-date-label'>
        <?php echo TimeUtil::prettyDate($travel['Travel']['original_date'])?>
    </span>
    </span>
    <?php endif;?>
    
    <b><?php echo __('Fecha del viaje')?>:</b> 
    <span id='travel-date-label'>
        <?php echo TimeUtil::prettyDate($travel['Travel']['date'])?>
    </span>
</p>

<p><b><?php echo __('Detalles del viaje')?>:</b> <span id='travel-details-label'><?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $travel['Travel']['details'])?></span></p>

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


<?php if($details && isset ($travel['DriverTravel']) && $showConversations):?>
    <p><b>Conversaciones:</b>
    <?php if($travel['Travel']['archive_conversations_count'] > 0): ?>
        <code><big><?php echo $travel['Travel']['archive_conversations_count']; ?> conversaciones en el archivo</big></code>
    <?php endif; ?>
    <ul id="conversations-travel-<?php echo $travel['Travel']['id']?>" style="list-style-type:none;margin-left: 20px">
        
        <?php foreach ($travel['DriverTravel'] as $sent) :?>
        <li><?php echo $this->element('conversation_id_decorated', array('conversation'=>$sent, 'showComments'=>false))?></li>
        <?php endforeach; ?>
        <li class="next-conversations"></li>
            
        <?php if(isset($drivers)):?>
            <?php if(!$expired):?>
                <li>
                    <span>
                        <a href="#!" class="open-modal" data-modal="notify-driver-travel-form-<?php echo $travel['Travel']['id']?>" data-title="Notificar este viaje a otro chofer"> 
                            Notificar este viaje a otro chofer
                        </a>
                    </span>
                    <div id='notify-driver-travel-form-<?php echo $travel['Travel']['id']?>' style="display:none">
                        <div id="notification-regular-<?php echo $travel['Travel']['id']?>">
                            Si quieres enviar una nota al chofer (ej. es un viaje por acuerdo), da click aquí: 
                            <div><a href="#!" onclick="$('#notification-regular-<?php echo $travel['Travel']['id']?>, #notification-with-note-<?php echo $travel['Travel']['id']?>').toggle();">Poner una nota</a></div>
                            <hr/>
                            <?php echo $this->element('form_notify_driver', array('drivers'=>$drivers, 'travel_id'=>$travel['Travel']['id']))?>
                        </div>
                        
                        <div id="notification-with-note-<?php echo $travel['Travel']['id']?>" style="display:none">
                            <div><a href="#!" onclick="$('#notification-regular-<?php echo $travel['Travel']['id']?>, #notification-with-note-<?php echo $travel['Travel']['id']?>').toggle();">No poner nota al chofer</a></div>
                            <hr/>
                            <?php echo $this->element('form_notify_driver', array('drivers'=>$drivers, 'travel_id'=>$travel['Travel']['id'], 'isArranged'=>true, 'notificationType'=>DriverTravel::$NOTIFICATION_TYPE_PREARRANGED))?>
                        </div>
                        
                        <hr/>
                        <!-- DATOS DEL VIAJE -->
                        <div><?php echo $travel['Travel']['origin']?> - <?php echo $travel['Travel']['destination']?></div>
                        <div><?php echo $pretty_people_count?></div>
                        <div>Creado hace <?php echo $daysPosted?> días, para el <?php echo TimeUtil::prettyDate($travel['Travel']['date'])?></div>
                    </div>
                </li>
            <?php else:?>
                <li><span class="text-danger" style="margin-top: 5px">Expirado, no se pueden notificar más choferes</span></li>
            <?php endif?>
        <?php endif?>
            
        </ul>
    </p>
<?php endif?>

<?php if($actions):?>
    <ul style="list-style-type: none;padding:0px">
        
        <?php if(!$expired):?>
        <li style="padding-right: 10px;display: inline-block">
        <?php echo $this->Html->link(
                __('Ver detalles').' »', 
                array('controller'=>'requests', 'action'=>'view/'.$travel['Travel']['id']), 
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

</div>