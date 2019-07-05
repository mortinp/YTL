<?php App::uses('TimeUtil', 'Util')?>
<?php App::uses('PathUtil', 'Util')?>

<div class="media-container-row offset-1" id="<?php echo $reply['id']; ?>" style="background-color: white!important; margin-top: 10px; margin-bottom: 10px; border-radius: 15px">
    <div class="media-content px-3 align-self-center mbr-white py-2">
        <p class="mbr-author-name pt-4 mb-2 mbr-fonts-style display-6">
            <span class="fa fa-reply"></span> <?php echo $driver['DriverProfile']['driver_name']?>            
        </p>
        <p class="mbr-author-desc mbr-fonts-style display-6 text-muted">
           <?php echo __d('mobirise/testimonials', 'Escrita el %s', TimeUtil::prettyDate($reply['created'], false))?>
        </p>
        <p class="mbr-text testimonial-text mbr-fonts-style display-7">
            <span style="font-style: normal;">
                <?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $reply['reply_text']);?>
            </span>
        </p>       
        
    </div>  
    

    
</div>