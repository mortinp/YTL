<?php
$pass = array('driver' => $driver);
if (isset($user))
    $pass = array_merge($pass, array('travel' => $travel, 'user' => $user));
if (isset($driver_profile))
    $pass = array_merge($pass, array('driver_profile' => $driver_profile));
?>

<div class="row" id="<?php echo "testimonial{$testimonial['id']}"; ?>">
    <div class="row"> <?php echo $this->element('testimonial_header', $pass);?></div>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title"><?php echo "<b>Testimonio {$testimonial['id']}:</b>"; ?>
                &nbsp;
                <?php echo $this->Html->link('admin »', array('controller' => 'testimonials', 'action' => 'admin', $testimonial['id']))?>
                &nbsp;               
                <?php echo $this->Html->link('permalink »', array('language'=>$testimonial['lang'], 'controller' => 'drivers', 'action' => 'profile',$driver_profile['driver_nick'],'?'=>array('see-review'=>$testimonial['id'])), array('target'=>'_blank'))?>
                &nbsp;
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $this->Html->url(array('controller' => 'drivers', 'action' => 'profile',$driver_profile['driver_nick'],'?'=>array('see-review'=>$testimonial['id']))) ?>" class="glyphicon glyphicon-share" target="_blank"></a>           
            </div>
        </div>

        <div class="panel-body">
            <?php
            echo $this->element('testimonial_admin', array('testimonial' => $testimonial));
            echo $this->element('testimonial_body', array('testimonial' => $testimonial, 'width' => 25, 'height' => 25));
            ?>
        </div>
    </div>
    
</div>