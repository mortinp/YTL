<?php
if(!isset ($modal)) $modal = false; // Esto es para hacer que el formulario se comporte de forma modal o no
?>

<!-- GANANCIAS -->
<?php if($conversation['TravelConversationMeta']['income'] != null && $conversation['TravelConversationMeta']['income'] != 0):?>
    <span class="label label-success info" title="Ganancia total"><i class="glyphicon glyphicon-usd"></i><?php echo $conversation['TravelConversationMeta']['income']?></span>
<?php endif?>
<?php if($conversation['TravelConversationMeta']['income_saving'] != null && $conversation['TravelConversationMeta']['income_saving'] != 0):?>
    <span class="label label-default info" title="Ahorro"><i class="glyphicon glyphicon-usd"></i><?php echo $conversation['TravelConversationMeta']['income_saving']?></span>
<?php endif?>

<!-- TODO: Poner ganancias solo los super administradores -->
<?php if(AuthComponent::user('username') == 'mproenza@grm.desoft.cu' || AuthComponent::user('username') == 'martin@yotellevocuba.com'):?>
    <span id="income-set-<?php echo $thread['id']?>" style="display: inline-block">
        <a href="#!" class="open-form edit-income-<?php echo $thread['id']?>" data-form="income-form-<?php echo $thread['id']?>">&ndash; <?php echo __('ganancia')?></a>
    </span>
    <span id="income-cancel-<?php echo $thread['id']?>" style="display:none">
        <a href="#!" class="cancel-edit-income-<?php echo $thread['id']?>">&ndash; <?php echo __('cancelar')?></a>
    </span>
    <div id='income-form-<?php echo $thread['id']?>' style="display:none">
        <br/>
        <?php echo $this->element('travel_income_form', array('data' => $conversation)); ?>
    </div>

    <?php if(!$modal):?> <!-- Inline form -->
    <script type="text/javascript">
        $('.edit-income-<?php echo $thread['id']?>, .cancel-edit-income-<?php echo $thread['id']?>').click(function() {
            $('#income-form-<?php echo $thread['id']?>, #income-set-<?php echo $thread['id']?>, #income-cancel-<?php echo $thread['id']?>').toggle();
        });
    </script>
    <?php endif?>
<?php endif?>