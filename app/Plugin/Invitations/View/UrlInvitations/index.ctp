<span class="alert alert-info" style="display: inline-block"><i class="glyphicon glyphicon-exclamation-sign"></i> Las invitaciones son urls del sitio que se comparten temporalmente para un usuario que normalmente no tiene acceso a esa url, o para cualquiera que use el token de la invitación.</span>
<div><?php echo $this->Html->link('Nueva Invitación', array('action'=>'add'))?></div>
<br/>

<?php foreach ($invitations as $i):?>
    <span class="label label-primary"><?php echo $i['UrlInvitation']['allowed_visits_count']?> permitido</span> 
    <span class="label label-info"><?php echo $i['UrlInvitation']['visited_count']?$i['UrlInvitation']['visited_count']:0?> visitado</span>
    <span><b>url compartida:</b> <?php echo $i['UrlInvitation']['url']?></span>
    <span><?php echo $this->Html->link($i['UrlInvitation']['id'], array('action'=>'visit/'.$i['UrlInvitation']['id']))?></span>
    <?php if($i['UrlInvitation']['comments'] != null):?>
    <span class="info" title="<?php echo $i['UrlInvitation']['comments']?>" style="margin-left: 30px"><i class="glyphicon glyphicon-exclamation-sign"></i></span>
    <?php endif; ?>
    <?php if($i['UrlInvitation']['message_to_invitee'] != null):?>
    <span class="info" title="<?php echo $i['UrlInvitation']['message_to_invitee']?>" style="margin-left: 30px"><i class="glyphicon glyphicon-comment"></i></span>
    <?php endif; ?>
    <br/>
    <?php $urlDef = array('controller' => 'url_invitations', 'action' => 'visit/'.$i['UrlInvitation']['id'], 'base'=>false)?>
    <span><b>Enviar al invitado esta dirección:</b> <big><?php echo $this->Html->url($urlDef, true)?></big></span>
    <br/>
    <br/>
<?php endforeach; ?>
