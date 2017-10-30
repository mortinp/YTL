<?php 
    $this->request->data = $data;
    echo $this->Html->script('ajaxify/forms');
?>

<div>
    <?php echo $this->Form->create('TravelConversationMeta', array('url' => array('controller' => 'driver_traveler_conversations', 'action' =>'set_income/'.$data['TravelConversationMeta']['conversation_id']))); ?>
    <fieldset>
        <?php
        echo $this->Form->input('conversation_id', array('type'=>'hidden'));
        echo $this->Form->input('income', array('type'=>'text', 'class'=>'input-sm', 'label'=>'Total del viaje'));
        echo $this->Form->input('income_saving', array('type'=>'text', 'class'=>'input-sm', 'label'=>'Ahorro de YoTeLlevo'));
        echo $this->Form->submit('Salvar');        
        ?>
    </fieldset>
    <?php echo $this->Form->end(); ?>
</div>

<script type="text/javascript">
    $('document').ready( function(){
        _ajaxifyForm(
            $('.bootbox form'),
            null,
           
            //onSuccess
            function(obj){
                $('#ganancias-' + obj.id).find('*').remove().end()
                    .append( $('<span class="label label-success info" title="Ganancia total"><i class="glyphicon glyphicon-usd"></i>' + obj.income + '</span>') )
                    .append( $('<span class="label label-default info" title="Ahorro"><i class="glyphicon glyphicon-usd"></i>' + obj.income_saving + '</span>')
                );
                
               var income_total = $('#income-total');
               income_total.text(income_total.text() * 1 + obj.income_dif);
                
               var income_save_total = $('#income-save-total');
               income_save_total.text(income_save_total.text() * 1 + obj.income_saving_dif);
                
                var boxes = $('#ganancias-' + obj.id).find('.info');
                boxes.filter(':first').css('margin-right' ,'.4em');
                    
                $.each(boxes, function(pos, obj) {
                    var placement = 'bottom';
                    if($(obj).attr('data-placement') !== undefined) placement = $(obj).attr('data-placement');
                    $(obj).tooltip({placement:placement, html:true});
                });
                
                //$('#content').prepend("<div class='alert alert-info alert-dismissable' style='text-align: center'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Se guardÃ³ la ganancia del viaje <b>" + obj.id + "</b> exitosamente.</div>");    
                $(".bootbox").modal("hide");    
            },
        
            // onError
            function(jqXHR) {
                alert(jqXHR.responseText);
            }
        );
    });
</script>