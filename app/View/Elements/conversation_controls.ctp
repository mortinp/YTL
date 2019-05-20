
<hr/>
<span class="col-md-12">    
    <!-- DRIVER MESSAGING -->
    <div id="messaging-controls">
        <?php echo $this->element('driver_messaging_controls', array('thread' => $data['DriverTravel'], 'conversation'=>$data)); ?>
    </div>
    <!-- COMMENTS -->
    <div id="comment-controls">
        <?php echo $this->element('travel_comments_controls', array('thread' => $data['DriverTravel'], 'conversation'=>$data)); ?>
    </div>
    <br>
</span>