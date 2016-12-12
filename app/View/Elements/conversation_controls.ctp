<?php echo $this->element('conversation_toolbox')?>

<hr/>
<span>
    <!-- COMMENTS -->
    <div style="float:right;margin-right: 30px;">
        <?php echo $this->element('travel_comments_controls', array('thread' => $data['DriverTravel'], 'conversation'=>$data)); ?>
    </div
</span>