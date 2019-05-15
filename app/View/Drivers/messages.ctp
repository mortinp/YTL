<!-- VIAJES Y CONTROLES -->
<?php
$driverName = 'el chofer'.' <small class="text-muted">('.$data['Driver']['username'].')</small>'?>
<?php $hasProfile = isset ($data['Driver']['DriverProfile']) && $data['Driver']['DriverProfile'] != null && !empty ($data['Driver']['DriverProfile'])?>
<?php if($hasProfile) :?>
    <?php
        $src = '';
        if(Configure::read('debug') > 0) $src .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien
        $src .= 'http://localhost/ytl-master/'.str_replace('\\', '/', $data['Driver']['DriverProfile']['avatar_filepath']);
        
        $driverName = $data['Driver']['DriverProfile']['driver_name'].'</small>';
    ?>
<?php endif;?>

<header id="header">
    <div id="navbar" class="navbar navbar-default navbar-fixed-top" role="navigation">
        <nav id="nav">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">                                                 
                <span class="pull-left">
                            <?php echo $this->Html->link($this->Html->image('logo-big-notext.jpg',array('style'=>' height:5.8rem')), "/", array('escape'=>false, 'style'=>'text-decoration:none;')) ?>

                </span>
                <span class="navbar-brand"><big>Yo</big>Te<big>Llevo</big><big> <b>Chofer</b></big></span>
                <!--<div class="pull-left navbar-brand">
                            <?php //$lang = SessionComponent::read('Config.language');?>
                            <?php //if($lang != null && $lang == 'en'):?>
                    <div class="nav-link info" title="Traducir al Español"><?php echo $this->Html->link($this->Html->image('Spain.png'), $lang_changed_url, array('escape'=>false, 'style'=>'text-decoration:none')) ?></div>
                            <?php //else:?>
                    <div class="nav-link info" title="Translate to English"><?php echo $this->Html->link($this->Html->image('UK.png'), $lang_changed_url, array('escape'=>false, 'style'=>'text-decoration:none')) ?></div>
                            <?php //endif;?>
                </div>-->            
                

            </div>
            
            <div class="nav-link pull-right">
                    <?php if($hasProfile):?><img src="<?php echo $src?>" title="<?php echo $data['Driver']['DriverProfile']['driver_name']?>" style="max-height: 3.9em; max-width: 3.9em"/><?php endif;?>
            <?php echo $driverName." " ?>
                    
                <?php echo $this->html->link('Vea su perfil>>',array('controller'=>'drivers', 'action'=>'profile/'.$data['Driver']['DriverProfile']['driver_nick']),array('target'=>'_blank')); ?>
                    | <h3 class="badge btn-primary">Viaje #<?php echo DriverTravel::getIdentifier($data)?></h3>
                
            
            </div>
              
            
            <!-- Collect the nav links, forms, and other content for toggling -->
            <!--<div class="collapse navbar-collapse" id="app-navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><?php echo $this->Html->link(__d('homepage', 'Entrar'), array('controller' => 'users', 'action' => 'login'), array('class' => 'nav-link', 'rel'=>'nofollow')) ?></li>
                </ul>



            </div><!-- /.navbar-collapse -->

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
    <div class="col-md-9">
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
<div class="col-md-6 col-md-offset-2">
    <div class="alert alert-warning" style="display: inline-block"><?php echo __('Parece que aún no has respondido a esta solicitud :( ...')?></div>
</div>
    <?php endif?>


<?php endif?>