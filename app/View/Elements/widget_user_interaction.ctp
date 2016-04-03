
<span><b><?php echo $interaction['UserInteraction']['interaction_due']?></b></span>
<span><?php echo $interaction['UserInteraction']['interaction_code']?></span>
                
<?php if($interaction['UserInteraction']['sent']):?>
<span class="label label-default">Enviado</span>
<?php endif?>
<?php if($interaction['UserInteraction']['visited']):?>
<span class="label label-warning">Visitado</span>
<?php endif?>
<?php if($interaction['UserInteraction']['expired']):?>
<span class="label label-success">Usado</span>
    <?php if($interaction['UserInteraction']['interaction_due'] == UserInteraction::$INTERACTION_TYPE_FIND_CASAS
            && isset ($interaction['CasaFindRequest']) 
            && !empty($interaction['CasaFindRequest']) 
            && $interaction['CasaFindRequest']['id'] != null 
            /*Esto ultimo es un invento considerando que si el id es null, entonces la CasaFindRequest no existe para esta interaccion*/):?>

        <span id="request-view-<?php echo $interaction['CasaFindRequest']['id']?>" style="display: inline-block">
            <a href="#!" class="view-request-<?php echo $interaction['CasaFindRequest']['id']?>">&ndash; <?php echo __('ver solicitud')?></a>
        </span>
        <span id="request-hide-<?php echo $interaction['CasaFindRequest']['id']?>" style="display:none">
            <a href="#!" class="hide-request-<?php echo $interaction['CasaFindRequest']['id']?>">&ndash; <?php echo __('ocultar solicitud')?></a>
        </span>
        <div id='request-<?php echo $interaction['CasaFindRequest']['id']?>' style="display:none; border:#efefef solid 2px; padding: 10px">
            <p><b>Solicitud de casas #<?php echo $interaction['CasaFindRequest']['id']?></b></p>
            <p><b>Nombres:</b> <?php echo $interaction['CasaFindRequest']['guests_names']?></p>
            <p><b>Detalles:</b> <?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $interaction['CasaFindRequest']['details']);?></p>
            <p><b>Enviada a:</b> <?php echo $interaction['CasaFindRequest']['send_to']?></p>
            <p><b>Creada:</b> 
                <?php 
                $created_converted = strtotime($interaction['CasaFindRequest']['created']);
                $now = new DateTime(date('Y-m-d', time()));
                $daysPosted = $now->diff(new DateTime($interaction['CasaFindRequest']['created']), true)->format('%a');
                echo date('d-m-Y', $created_converted);
                ?>
                <span class="text-muted">(hace <?php echo $daysPosted?> días)</span>
            </p>
        </div> 

    <?php endif?>
<?php endif?>

<?php if(isset ($interaction['User'])):?>
<p>
    Usuario: <?php echo $interaction['User']['username']?> <?php echo $this->Html->link('admin »', array('controller'=>'users', 'action'=>'admin/'.$interaction['User']['id']), array('title'=>'Ir a la pantalla de administración de este usuario'))?>
</p>
<?php endif; ?>

<script type="text/javascript">
    $('.view-request-<?php echo $interaction['CasaFindRequest']['id']?>, .hide-request-<?php echo $interaction['CasaFindRequest']['id']?>').click(function() {
        $('#request-<?php echo $interaction['CasaFindRequest']['id']?>, #request-view-<?php echo $interaction['CasaFindRequest']['id']?>, #request-hide-<?php echo $interaction['CasaFindRequest']['id']?>').toggle();
    });
</script>
