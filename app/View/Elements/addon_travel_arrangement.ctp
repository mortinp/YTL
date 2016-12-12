<?php 
$hasMetadata = (isset ($data['TravelConversationMeta']) && $data['TravelConversationMeta'] != null && !empty ($data['TravelConversationMeta']) && strlen(implode($data['TravelConversationMeta'])) != 0);
?>

<?php if($hasMetadata && !empty($data['TravelConversationMeta']['arrangement'])):?>
<span class="alert alert-warning" style="display: inline-block; width: 100%">
    <p>
        <b>Este viaje fue <code>ACORDADO</code> con este chofer</b>
    </p>
    <hr/>
    <p><?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $data['TravelConversationMeta']['arrangement']);?></p>
</span>
<?php endif?>