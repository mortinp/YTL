<?php app::uses('TimeUtil', 'Util'); ?>

<?php $messageId = 'message-'.$message['id']?>
        
<?php
if($message['response_by'] == 'driver') {
    $label = (isset($driver_name))? $driver_name:__('Chofer');
    $class = 'col-md-8 alert bg-info';
} else {
    $label = __('Tú');
    $class = 'col-md-8 col-md-offset-4 well';
}
?>

<div class="<?php echo $class?>" id="<?php echo $messageId?>">
    
    <?php
    $created_converted = strtotime($message['created']);
    $now = new DateTime(date('Y-m-d', time()));
    $daysPosted = $now->diff(new DateTime($message['created']), true)->format('%a');
    ?>
    <div>
        <span class="text-muted <?php if(!$message['read_by']) echo 'porleer'; ?>">
            <a href="#<?php echo $messageId?>" style="color: inherit">
                <?php echo __('%s el %s, hace %s días', '<b>'.$label.'</b>', '<b>'.TimeUtil::prettyDate($message['created'], false).'</b>', $daysPosted )?>
            </a>
            <?php $hasSource = isset($message['msg_source']) && $message['msg_source'] != null && $message['msg_source'] != 'UNK' ?>
            <?php if($hasSource):?>
                <?php 
                $source = '--';
                if($message['msg_source'] === 'WEB') $source = 'WEB';
                else if($message['msg_source'] === 'EML') $source = 'EMAIL';
                else if($message['msg_source'] === 'APP') $source = 'MOBILE APP';
                ?>
                <div class="small">
                    <?php echo __('Enviado desde %s', $source )?>
                </div>
            <?php endif?>
        </span>
        
        <?php if(in_array($userRole, array('admin', 'operator')) && $message['read_by']):?>
            <small><code class="pull-right info" title="Leído por <?php echo $message['read_by']?>"><?php echo $message['read_by']?> <?php if($message['date_read'] != null) echo 'el '.TimeUtil::prettyDate($message['date_read'], false)?></code></small>
        <?php endif?>
    </div>
    <br/>
    
    <?php if($message['attachments_ids'] != null && $message['attachments_ids'] != ''):?>
        <div class="alert">
            <a href="#!" id="show-attachments-<?php echo $messageId?>" data-attachments-ids="<?php echo $message['attachments_ids']?>">
                <i class="glyphicon glyphicon-link"></i> <?php echo __('Ver adjuntos de este mensaje')?>
            </a>
            <div id="attachments-<?php echo $messageId?>" style="display:none"></div>
        </div>
        <script type="text/javascript">
            $('#show-attachments-<?php echo $messageId?>').click(function() {

                $.ajax({
                    type: "POST",
                    data: $('#show-attachments-<?php echo $messageId?>').data('attachments-ids'),
                    url: '<?php echo $this->Html->url(array('controller'=>'email_queues', 'action'=>'get_attachments/'.$message['attachments_ids']))?>',
                    success: function(response) {
                        //alert(response);
                        response = JSON.parse(response);

                        var place = $('#attachments-<?php echo $messageId?>');
                        for (var a in response.attachments) {
                            var att = response.attachments[a];
                            if(att.mimetype.substr(0, 5) == 'image') {
                                place.append($('<img src="' + att.url + '" class="img-responsive"></img>')).append('<br/>');
                            } else if(att.mimetype == 'text/plain') {
                                place.append('<a href="'+ att.url + '"> <i class="glyphicon glyphicon-file"></i> ' + att.filename + '</a>').append('<br/>');
                            } else {
                                place.append('<a href="'+ att.url + '"> <i class="glyphicon glyphicon-file"></i> ' + att.filename + '</a>').append('<br/>');
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
        
    <?php endif?>
    
    <?php 
        $msgWasShortened = false;
        $text = strip_tags(trim($message['response_text']));
        
        $originalText = $text;
        
        $text = preg_replace("/\d+\.*\d*\s*(\r\n|\n|\r)*cuc*/i", "<b>$0</b>", $text);
        $text = preg_replace("/\d+\.*\d*\s*(\r\n|\n|\r)*(kms*|kilometros*|kilómetros*)/i", '<span style="color:tomato"><b>$0</b></span>', $text);
        $text = preg_replace("/(\r\n|\n|\r)/", "<br/>", $text);
        
        $fullText = $shortText = $text;
        
        if(strpos($originalText, Configure::read('email_message_separator_stripped'))) {
            $shortText = substr($originalText, 0, strpos($originalText, Configure::read('email_message_separator_stripped')));
            $shortText = preg_replace("/\d+\.*\d*\s*(\r\n|\n|\r)*cuc*/i", "<b>$0</b>", $shortText);
            $shortText = preg_replace("/\d+\.*\d*\s*(\r\n|\n|\r)*(kms*|kilometros*|kilómetros*)/i", '<span style="color:tomato"><b>$0</b></span>', $shortText);
            $shortText = preg_replace("/(\r\n|\n|\r)/", "<br/>", $shortText);
            
            $msgWasShortened = true;
        }
    ?>
        
    <?php if($msgWasShortened):?>
        <div id="msg-full-body-<?php echo $messageId?>" style="display: none">
            <?php echo $fullText; ?>
        </div>
    <?php endif;?>

    <div id="msg-body-<?php echo $messageId?>">
        <?php echo $shortText; ?>

        <?php if($msgWasShortened):?>
            <br/>
            <br/>
            <a href="#!" id="view-full-message-<?php echo $messageId?>"><?php echo __('Ver todo el mensaje')?></a>
            <script type="text/javascript">
                $('#view-full-message-<?php echo $messageId?>').click(function() {
                    $('#msg-body-<?php echo $messageId?>').html('').html($('#msg-full-body-<?php echo $messageId?>').html());
                });
            </script>
        <?php endif;?>
    </div>
        
</div>