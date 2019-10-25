<?php app::uses('TimeUtil', 'Util'); ?>
<?php
    if(!isset($show_message)) $show_message = false;
    
    $message = isset($data['DriverTravelerConversation'][0]) ? $data['DriverTravelerConversation'][0] : null;
    $conversation = $data['DriverTravel'];
    $driver_profile = isset($data['Driver']['DriverProfile']) ? $data['Driver']['DriverProfile'] : null;
    $driver_nick = ( isset($driver_profile['driver_nick']) ) ? $driver_profile['driver_nick'] : null;
    $driver_name = ( isset($driver_profile['driver_name']) ) ? Driver::shortenName( $driver_profile['driver_name'] ) : null; 
    
    $now = new DateTime(date('Y-m-d', time()));
    $daysPosted = $now->diff(new DateTime($message['created']), true)->format('%a');
    
    $pretty_date = TimeUtil::prettyDate($discount['DiscountRide']['date']);
    $date_converted = strtotime($discount['DiscountRide']['date']);

    $expired = CakeTime::isPast($date_converted) && !CakeTime::isToday($date_converted);
    if($expired) $pretty_date .= ' <span class="badge">Expirado</span>';
?>
<div>
    <h2>
        <span style="display: inline-block">                     
            <small><?php echo $discount['DiscountRide']['origin']. ' - '. $discount['DiscountRide']['destination']; ?></small>
        </span> 
    </h2>
    <div class="plan-price">
        <span class="price-value mbr-fonts-style display-5">$</span>
        <span class="price-figure mbr-fonts-style display-2"><?php echo $discount['DiscountRide']['price']; ?></span>
        <small class="price-term mbr-fonts-style display-7">CUC <br><b><?php echo __d('mobirise/cheap_taxi', 'hasta %s personas', $discount['DiscountRide']['people_count'])?></b></small>
    </div>
</div>
<hr/>

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