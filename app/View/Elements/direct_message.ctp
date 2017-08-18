<?php app::uses('TimeUtil', 'Util'); ?>
<?php
    if(!isset($show_message)) $show_message = false;
    if(!isset($show_perfil)) $show_perfil = true;
    if(!isset($show_header)) $show_header = true;
    
    $message = isset($data['DriverTravelerConversation'][0]) ? $data['DriverTravelerConversation'][0] : null;
    $conversation = $data['DriverTravel'];
    $driver_profile = isset($data['Driver']['DriverProfile']) ? $data['Driver']['DriverProfile'] : null;
    $driver_nick = ( isset($driver_profile['driver_nick']) ) ? $driver_profile['driver_nick'] : null;
    $driver_name = ( isset($driver_profile['driver_name']) ) ? Driver::shortenName( $driver_profile['driver_name'] ) : null; 
    
    $now = new DateTime(date('Y-m-d', time()));
    $daysPosted = $now->diff(new DateTime($message['created']), true)->format('%a');
?>

<?php if($show_header): ?>
    <div>
        <?php 
        if(isset ($driver_profile) && $driver_profile != null && !empty ($driver_profile)) :?>
            <?php
                $src = '';
                if(Configure::read('debug') > 0) $src .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien
                $src .= '/'.str_replace('\\', '/', $driver_profile['avatar_filepath']);
            ?>
            <img src="<?php echo $src?>" alt="<?php echo $driver_profile['driver_name']?>" class="info" title="<?php echo $driver_profile['driver_name']?>" style="max-width: 40px;max-height: 40px"/>
            <?php echo __('Solicitud directa a %s', '<big><code>'.$driver_name.'</code></big>')?>
        <?php endif;?>
        
    </div>
    <hr/>
<?php endif; ?>
    
<?php if($show_perfil): ?>
    <p>
        <span class="info" title="<?php echo __d('testimonials', 'Mira fotos de %s', $driver_name)?>">
            <?php echo $this->Html->link(__d('testimonials', 'Ver el perfil de %s', $driver_name).' »', array('controller'=>'drivers', 'action'=>'profile/'.$driver_nick), array('target'=>'_blank', 'class'=>'text-warning'))?>
        </span>
    </p>
<?php endif; ?>
    
<p> 
    <?php if($userLoggedIn && in_array($userRole, array('admin', 'operator'))):?>    
        <?php $fechaCambiada = isset ($conversation['original_date']) && $conversation['original_date'] != null;?>
        <?php if($fechaCambiada):?>
            <span class="badge">
            <b><?php echo __('Fecha original')?>:</b> 
            <span id='travel-date-label'>
                <?php echo TimeUtil::prettyDate($conversation['original_date'])?>
            </span>
            </span>
        <?php endif;?>
    <?php endif;?>

    <b><?php echo __('Fecha del viaje')?>:</b> 
    <span id='travel-date-label'>
        <?php echo TimeUtil::prettyDate($conversation['travel_date'])?>
    </span>
</p>

<?php if( in_array(AuthComponent::user('role'), array('admin', 'operator')) ): ?>
    <p><b>Creado por:</b> 
        <?php
        $now = new DateTime(date('Y-m-d', time()));
        $daysPosted = $now->diff(new DateTime($conversation['created']), true)->format('%a');

        if(isset ($data['User'])) 
            $user = $data['User'];
        else if(isset ($conversation['User'])) 
            $user = $conversation['User'];

        echo $user['username'].' '.$this->Html->link($user['travel_count'].' viajes', array('controller'=>'users', 'action'=>'view_travels/'.$user['id'])).' | '.$this->Html->link('admin »', array('controller'=>'users', 'action'=>'admin/'.$user['id']), array('title'=>'Ir a la pantalla de administración de este usuario'));
        echo ' - '.'<span class="text-muted">(creado hace '.$daysPosted.' días)</span>';
        ?>
    </p>
<?php endif; ?>

<?php if($show_message && isset($message) && $message != null): ?>
    <p><b><?php echo __('Mensaje enviado')?>:</b> <?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $message['response_text']); ?></p>
<?php endif; ?>    