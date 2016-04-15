<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <legend>Acuerdo de viaje del chofer <?php echo $data['Driver']['username']?></legend>
        
        <?php echo $this->element('travel', array('travel'=>$data, 'details'=>true, 'showConversations'=>false, 'actions'=>false))?>
        <div>
            <?php echo $this->element('conversation_controls', array('data'=>$data))?><!-- Acciones para esta conversación -->
        </div>
    </div>
</div>
<br/>

<!--<?php if(isset ($data['Driver']['DriverProfile']) && $data['Driver']['DriverProfile'] != null && !empty ($data['Driver']['DriverProfile'])) :?>
    <?php
        $src = '';
        if(Configure::read('debug') > 0) $src .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien
        $src .= '/'.str_replace('\\', '/', $data['Driver']['DriverProfile']['avatar_filepath']);
    ?>
    <img src="<?php echo $src?>" title="<?php echo $data['Driver']['DriverProfile']['driver_name'].' - '.$data['Driver']['username']?>" style="max-height: 40px; max-width: 40px"/>
<?php endif;?>-->

<?php foreach ($conversations as $c):?>

<div class="row container-fluid">
    <div class="col-md-10 col-md-offset-1">
        <?php $messageId = 'message-'.$c['DriverTravelerConversation']['id']?>
        
        <?php
        if($c['DriverTravelerConversation']['response_by'] == 'driver') {
            $label = 'Chofer';
            $class = 'col-md-8 alert bg-info';
        } else {
            $label = 'Viajero';
            $class = 'col-md-8 col-md-offset-4 well';
        }
        ?>
        
        <div class="<?php echo $class?>" id="<?php echo $messageId?>">
            <?php if($c['DriverTravelerConversation']['attachments_ids'] != null && $c['DriverTravelerConversation']['attachments_ids'] != ''):?>
                <div class="alert alert-info">
                    <a href="#!" id="show-attachments-<?php echo $messageId?>" data-attachments-ids="<?php echo $c['DriverTravelerConversation']['attachments_ids']?>">
                        <i class="glyphicon glyphicon-link"></i> &ndash; <?php echo __('ver adjuntos de este mensaje')?>
                    </a>
                    <div id="attachments-<?php echo $messageId?>" style="display:none"></div>

                    <script type="text/javascript">
                        $('#show-attachments-<?php echo $messageId?>').click(function() {
                            
                            $.ajax({
                                type: "POST",
                                data: $('#show-attachments-<?php echo $messageId?>').data('attachments-ids'),
                                url: '<?php echo $this->Html->url(array('controller'=>'email_queues', 'action'=>'get_attachments/'.$c['DriverTravelerConversation']['attachments_ids']))?>',
                                success: function(response) {
                                    alert(response);
                                    response = JSON.parse(response);
                                    
                                    var place = $('#attachments-<?php echo $messageId?>');
                                    for (var a in response.attachments) {
                                        var att = response.attachments[a];
                                        if(att.mimetype.substr(0, 5) == 'image') {
                                            //alert('imagen: ' + att.url);
                                            //alert($('#attachments-<?php echo $messageId?>').attr('id'));
                                            place.append($('<img src="' + att.url + '"></img>')).append('<br/><br/>');
                                        } else if(att.mimetype == 'text/plain') {
                                            place.append('<a href="'+ att.url + '"> <i class="glyphicon glyphicon-file"></i> ' + att.filename + '</a>').append('<br/><br/>');
                                        } else {
                                            place.append('<a href="'+ att.url + '"> <i class="glyphicon glyphicon-file"></i> ' + att.filename + '</a>').append('<br/><br/>');
                                        }
                                    }
                                    
                                    $('#attachments-<?php echo $messageId?>, #show-attachments-<?php echo $messageId?>').toggle();
                                    
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    alert(jqXHR.responseText);
                                },
                                complete: function() {
                                    
                                }
                            });
                            
                        });
                    </script>
                </div>
            <?php endif?>
            
            <b><a href="#<?php echo $messageId?>" style="color: inherit"><?php echo $label?> (<?php echo $c['DriverTravelerConversation']['created']?>)</a></b>
            <br/>
            <br/>
            <?php
            $message = preg_replace("/\d+\.*\d*\s*(\r\n|\n|\r)*cuc*/i", "<b>$0</b>", trim($c['DriverTravelerConversation']['response_text']));
            $message = preg_replace("/\d+\.*\d*\s*(\r\n|\n|\r)*(kms*|kilometros*|kilómetros*)/i", '<span style="color:tomato"><b>$0</b></span>', $message);
            $message = preg_replace("/(\r\n|\n|\r)/", "<br/>", $message);
            //$message = preg_replace("/cuc/i", '<big><abbr title="One of the currencies in Cuba">$0</abbr></big>', $message);// TODO: Mostrar una ayuda al lado de 'CUC', que enseñe qué es el CUC... o se puede poner un link al tipo de cambio actual...
            echo $message;
            ?>
        </div>
    </div>
    <br/>
</div>

<?php endforeach;?>

<?php if(empty ($conversations)):?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        No hay conversaciones hasta el momento
    </div>
</div>   
<?php endif?>