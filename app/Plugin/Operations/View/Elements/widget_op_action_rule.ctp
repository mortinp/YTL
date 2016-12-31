<?php
$owner = User::prettyName($rule['Owner']);
if($rule['Owner']['id'] == AuthComponent::user('id')) $owner = '<mark class="info" title="'.$owner.' eres tú :)">'.$owner.'</mark>';
        
$other = User::prettyName($rule['Other']);
if($rule['Other']['id'] == AuthComponent::user('id')) $other = '<mark class="info" title="'.$other.' eres tú :)">'.$other.'</mark>'
?>

<b><?php echo $owner?></b> le permite a <b><?php echo $other?></b> <code><big><?php echo OpActionRule::$rules[$rule['OpActionRule']['action_allowed']]?></big></code>
<?php if($rule['OpActionRule']['allowed_by_owner']):?>
    <span class="label label-success">Permitida por <?php echo User::prettyName($rule['Owner'])?></span>
<?php else:?>
    <span class="label label-danger">No permitida por <?php echo User::prettyName($rule['Owner'])?></span>
<?php endif?>
<?php if($rule['OpActionRule']['accepted_by_other']):?>
    <span class="label label-success">Activada por <?php echo User::prettyName($rule['Other'])?></span>
<?php else:?>
    <span class="label label-danger">No activada por <?php echo User::prettyName($rule['Other'])?></span>
<?php endif?>