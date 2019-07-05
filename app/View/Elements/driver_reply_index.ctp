<?php
$pass = array('driver' => $driver);
if (isset($user))
    $pass = array_merge($pass, array('travel' => $travel, 'user' => $user));
if (isset($driver_profile))
    $pass = array_merge($pass, array('driver_profile' => $driver_profile));
?>

<div class="row" id="<?php echo "reply{$reply['id']}"; ?>">
    <div class="row"> <?php echo $this->element('driver_reply_header', $pass);?></div>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title"><?php echo "<b>Respuesta a testimonio ".$this->Html->link($testimonial['id'].'»', array('language'=>$testimonial['lang'], 'controller' => 'drivers', 'action' => 'profile',$driver_profile['driver_nick'],'?'=>array('see-review'=>$testimonial['id'])), array('target'=>'_blank','style'=>'color:white!important')).":</b>"?>                
                &nbsp;
                <?php /*echo $this->Html->link('admin »', array('controller' => 'testimonials', 'action' => 'admin', $reply['id']))*/?>
               </div>
        </div>

        <div class="panel-body">
            <?php
            echo $this->element('driver_reply_admin', array('reply' => $reply,'testimonial'=>$testimonial));
            echo $this->element('driver_reply_body', array('reply' => $reply,'driver'=>$driver, 'width' => 25, 'height' => 25));
            ?>
        </div>
    </div>
    
</div>