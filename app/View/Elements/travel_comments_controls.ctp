
<?php 
$comments = '';
if(isset ($conversation['TravelConversationMeta']['comments'])) $comments = $conversation['TravelConversationMeta']['comments'];

$colorClass = 'text-muted';
$title = 'Adicionar un comentario';
if(!empty($comments)) {
    $colorClass = 'text-info';
    $title = '';
}
?>

<span id="comments-set-<?php echo $thread['id']?>" style="display: inline-block">
    <a href="#!" title="<?php echo $title?>" class="edit-comments-<?php echo $thread['id']?>" style="text-decoration: none"><span class="info" title="<?php echo $comments?>"><i class="fa fa-comment <?php echo $colorClass?>"></i></span></a>
</span>
<span id="comments-cancel-<?php echo $thread['id']?>" style="display:none">
    <a href="#!" class="cancel-edit-comments-<?php echo $thread['id']?>">&ndash; cancelar</a>
</span>
<div id='comments-form-<?php echo $thread['id']?>' style="display:none">
    <br/>
    <span class="bg-warning text-warning">Si ya hay comentarios, no borres los anteriores y agrega el tuyo debajo.</span>
    <?php echo $this->element('travel_comments_form', array('data' => $conversation)); ?>
</div>

<script type="text/javascript">
    $('.edit-comments-<?php echo $thread['id']?>, .cancel-edit-comments-<?php echo $thread['id']?>').click(function() {
        $('#comments-form-<?php echo $thread['id']?>, #comments-set-<?php echo $thread['id']?>, #comments-cancel-<?php echo $thread['id']?>').toggle();
    });
</script>