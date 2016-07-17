<?php echo $this->element('conversation_toolbox')?>

<hr/>
<span>
    <!-- COMMENTS -->
    <div style="float:right;margin-right: 30px;">
        <?php echo $this->element('travel_comments_controls', array('thread' => $data['DriverTravel'], 'conversation'=>$data)); ?>
    </div
    
    <!-- ARRANGEMENTS -->
    <?php if(isset ($data['TravelConversationMeta']['arrangement']) && !empty($data['TravelConversationMeta']['arrangement'])):?>
    <div style="float:right;margin-right: 10px">
        <span class="info" title="<?php echo $data['TravelConversationMeta']['arrangement']?>"><i class="glyphicon glyphicon-thumbs-up"></i></span>
    </div>
    <?php endif?>
</span>