<?php $messageId = 'message-'.$message['id']?>
        
<?php
if($message['response_by'] == 'driver') {
    $label = 'Chofer';
    $class = 'col-md-8 alert bg-info';
} else {
    $label = 'Viajero';
    $class = 'col-md-8 col-md-offset-4 well';
}
?>

<div class="<?php echo $class?>" id="<?php echo $messageId?>">
    <?php if($message['attachments_ids'] != null && $message['attachments_ids'] != ''):?>
        <div class="alert alert-info">
            <a href="#!" id="show-attachments-<?php echo $messageId?>" data-attachments-ids="<?php echo $message['attachments_ids']?>">
                <i class="glyphicon glyphicon-link"></i> &ndash; <?php echo __('ver adjuntos de este mensaje')?>
            </a>
            <div id="attachments-<?php echo $messageId?>" style="display:none"></div>

            <script type="text/javascript">
                $('#show-attachments-<?php echo $messageId?>').click(function() {

                    $.ajax({
                        type: "POST",
                        data: $('#show-attachments-<?php echo $messageId?>').data('attachments-ids'),
                        url: '<?php echo $this->Html->url(array('controller'=>'email_queues', 'action'=>'get_attachments/'.$message['attachments_ids']))?>',
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

    <b><a href="#<?php echo $messageId?>" style="color: inherit"><?php echo $label?> (<?php echo $message['created']?>)</a></b>
    <br/>
    <br/>
    <?php
    $text = preg_replace("/\d+\.*\d*\s*(\r\n|\n|\r)*cuc*/i", "<b>$0</b>", trim($message['response_text']));
    $text = preg_replace("/\d+\.*\d*\s*(\r\n|\n|\r)*(kms*|kilometros*|kilómetros*)/i", '<span style="color:tomato"><b>$0</b></span>', $text);
    $text = preg_replace("/(\r\n|\n|\r)/", "<br/>", $text);
    //$message = preg_replace("/cuc/i", '<big><abbr title="One of the currencies in Cuba">$0</abbr></big>', $message);// TODO: Mostrar una ayuda al lado de 'CUC', que enseñe qué es el CUC... o se puede poner un link al tipo de cambio actual...
    echo $text;
    ?>
</div>