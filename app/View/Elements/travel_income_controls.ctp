<!-- GANANCIAS -->
<?php if($conversation['TravelConversationMeta']['income'] != null && $conversation['TravelConversationMeta']['income'] != 0):?>
    <span class="label label-success" style="margin-left:5px" title="Ganancia"><i class="glyphicon glyphicon-usd"></i><?php echo $conversation['TravelConversationMeta']['income']?></span>
<?php endif?>
<?php if($conversation['TravelConversationMeta']['income_saving'] != null && $conversation['TravelConversationMeta']['income_saving'] != 0):?>
    <span class="label label-default" style="margin-left:5px" title="Ahorro"><i class="glyphicon glyphicon-usd"></i><?php echo $conversation['TravelConversationMeta']['income_saving']?></span>
<?php endif?>

<!-- TODO: Poner ganancias solo los super administradores -->
<?php if(AuthComponent::user('username') == 'mproenza@grm.desoft.cu' || AuthComponent::user('username') == 'martin@yotellevocuba.com'):?>
    <span id="income-set-<?php echo $thread['id']?>" style="display: inline-block">
        <a href="#!" class="edit-income-<?php echo $thread['id']?>">&ndash; <?php echo __('poner ganancia')?></a>
    </span>
    <span id="income-cancel-<?php echo $thread['id']?>" style="display:none">
        <a href="#!" class="cancel-edit-income-<?php echo $thread['id']?>">&ndash; <?php echo __('cancelar')?></a>
    </span>
    <div id='income-form-<?php echo $thread['id']?>' style="display:none">
        <br/>
        <?php echo $this->element('travel_income_form', array('data' => $conversation)); ?>
    </div>

    <script type="text/javascript">
        $('.edit-income-<?php echo $thread['id']?>, .cancel-edit-income-<?php echo $thread['id']?>').click(function() {
            $('#income-form-<?php echo $thread['id']?>, #income-set-<?php echo $thread['id']?>, #income-cancel-<?php echo $thread['id']?>').toggle();
        });
    </script>
<?php endif?>