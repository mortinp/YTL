<!-- VIAJES Y CONTROLES -->
<?php
$driverName = 'el chofer'.' <small class="text-muted">('.$data['Driver']['username'].')</small>'?>
<?php $hasProfile = isset ($data['Driver']['DriverProfile']) && $data['Driver']['DriverProfile'] != null && !empty ($data['Driver']['DriverProfile'])?>
<?php if($hasProfile) :?>
    <?php
        $src = '';
        if(Configure::read('debug') > 0) $src .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien
        $src .= '/'.str_replace('\\', '/', $data['Driver']['DriverProfile']['avatar_filepath']);
        
        $driverName = $data['Driver']['DriverProfile']['driver_name'];
    ?>
<?php endif;?>

<header id="header">
    <div id="navbar" class="navbar navbar-default navbar-fixed-top" role="navigation">
        <nav id="nav">
            
            <div class="nav-link center" style="padding: 20px">
                <?php if($hasProfile):?><img src="<?php echo $src?>" style="max-height: 3.9em; max-width: 3.9em"/><?php endif;?>
                <?php echo 'Hola '.$driverName.'! ' ?>
                <?php echo $this->html->link('Vea su perfil',array('controller'=>'drivers', 'action'=>'profile', $data['Driver']['DriverProfile']['driver_nick'])); ?>
                <h4><small class="text-muted">#</small><?php echo DriverTravel::getIdentifier($data)?></h4>
            </div>    

        </nav>
    </div>
</header>

<div class="row" style="top: 200px"> 
    <div class="col-md-6 col-md-offset-3">
        <?php        
            if($data['DriverTravel']['notification_type'] == DriverTravel::$NOTIFICATION_TYPE_DIRECT_MESSAGE)
                echo $this->element('direct_message', array('data'=>$data, 'show_header' => false, 'show_perfil' => false));
            else echo $this->element('travel', array('travel'=>$data, 'showConversations'=>false, 'actions'=>false));
        ?>       
    </div>
</div>

<br/>
<br/>

<!-- MENSAJES -->
<?php if(empty ($conversations)):?><div class="row"><div class="col-md-6 col-md-offset-3">No hay mensajes hasta el momento</div></div>
<?php else:?>
    <?php 
    $driverMsgsCount = 0;
    $travelerMsgsCount = 0;
    ?>
    <?php foreach ($conversations as $message):?>
        <div class="row container-fluid">
            <div class="col-md-10 col-md-offset-1">
                <?php echo $this->element('widget_conversation_online', array('message'=>$message['DriverTravelerConversation'], 'driver_name'=>'Usted'))?>
            </div>
            <br/>
        </div>

        <?php 
        // Contar los mensajes del chofer y los mensajes del viajero
        if($message['DriverTravelerConversation']['response_by'] == 'driver') $driverMsgsCount++;
        else if($message['DriverTravelerConversation']['response_by'] == 'traveler') $travelerMsgsCount++;
        ?>
    <?php endforeach;?>

    <?php if($driverMsgsCount == 0):?>
<br/>
<br/>
<div class="col-md-8 col-md-offset-2">
    <div class="alert alert-warning" style="display: inline-block"><?php echo __('Parece que aún no has respondido a esta solicitud :( ...')?></div>
</div>
    <?php endif?>

<?php endif?>