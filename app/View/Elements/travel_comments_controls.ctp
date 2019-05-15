
<?php 
$comments = '';
if(isset ($conversation['TravelConversationMeta']['comments'])) $comments = $conversation['TravelConversationMeta']['comments'];

$colorClass = 'text-muted';
$title = 'Adicionar un comentario';
if(!empty($comments)) {
    $colorClass = 'text-info';
    $title = '';
}
else $comments = $title;
?>

<span id="comments-cancel-<?php echo $thread['id']?>" style="display:none;float:right;">
    <a href="#!" class="cancel-edit-comments-<?php echo $thread['id']?>">&ndash; cancelar</a>
</span>
<div id='comments-form-<?php echo $thread['id']?>' style="display:none">
    <br/>
    <br>
    <span class="bg-warning text-warning">Si ya hay comentarios, no borres los anteriores y agrega el tuyo debajo.</span>
    <?php echo $this->element('travel_comments_form', array('data' => $conversation)); ?>
</div>

<script type="text/javascript">
    
    $("#comment-icon").html("<span id='comments-set-<?php echo $thread['id']?>' style='display: inline-block;' class='btn btn-default'><a href='#!' title='<?php echo $title?>' class='edit-comments-<?php echo $thread['id']?>' style='text-decoration: none'><span class='info' title='<?php echo $comments?>'><i class='glyphicon glyphicon-comment <?php echo $colorClass?>'></i></span></a></span>");
        $('.edit-comments-<?php echo $thread['id']?>, .cancel-edit-comments-<?php echo $thread['id']?>').click(function() {
        $('#comments-form-<?php echo $thread['id']?>, #comments-cancel-<?php echo $thread['id']?>').toggle();
        $(".theme-config-box").toggleClass("show");
    });
</script>