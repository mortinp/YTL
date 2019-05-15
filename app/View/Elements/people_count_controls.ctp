
<?php 
$comments = '';
//Misma idea que para comentarios de viaje, usando el campo para enviar mensaje directo al usuario
$colorClass = 'text-muted';
$title = 'Cambiar cantidad de viajeros';
if(!empty($comments)) {
    $colorClass = 'text-info';
    $title = '';
}
else $comments = $title;
    
?>

<span id="people-set-<?php echo $thread['id']?>" style="display: inline-block;" class="btn btn-default">
    <a href="#!" title="<?php echo $title?>" class="edit-people-<?php echo $thread['id']?>" style="text-decoration: none"><span class="info" title="<?php echo $comments?>"><i class="glyphicon glyphicon-user <?php echo $colorClass?>"></i><i class="glyphicon glyphicon-plus-sign <?php echo $colorClass?>"></i></span></a>
</span>
<span id="people-cancel-<?php echo $thread['id']?>" style="display:none;float:right;">
    <a href="#!" class="cancel-edit-people-<?php echo $thread['id']?>">&ndash; cancelar</a>
</span>
<div class="col-md-12" id='people-form-<?php echo $thread['id']?>' style="display:none">
    <br/>    
    <?php echo $this->element('people_count_form', array('data' => $conversation)); ?>
    <br>
    <div id="success"></div>
</div>

<script type="text/javascript">
    $('.edit-people-<?php echo $thread['id']?>, .cancel-edit-people-<?php echo $thread['id']?>').click(function() {
        $('#people-form-<?php echo $thread['id']?>,#people-cancel-<?php echo $thread['id']?>').toggle();
    });
</script>