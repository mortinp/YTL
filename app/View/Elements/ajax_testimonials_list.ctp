<?php
    echo $this->Html->script('jquery', array('inline' => false));
    $this->Paginator->options(array(
        'update' => '.ajax-load:last',
        'evalScripts' => true,
        'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
        'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false))
    ));
?>

<?php foreach ($testimonials as $testimonial):?>
    <div class="col-md-8 col-md-offset-2">        
        <br/>
        <?php echo $this->element('testimonial_body', array('testimonial'=>$testimonial['Testimonial']));?>
        <br/>
    </div>
<?php endforeach?>

<div class="ajax-load">
    <div class="col-md-8 col-md-offset-2 center">
        <?php
            echo $this->Paginator->next(
                        '<big>'.__d('testimonials', 'VER MÁS OPINIONES').'...</big>',
                        array('class'=>'btn btn-warning', 'style'=>'color:inherit !important;text-decoration:none', 'escape'=> false),
                        __d('testimonials', 'No hay más opiniones'),
                        array('escape'=> false, 'class'=>'text-muted'));
            echo "<big>".$this->Html->image('loading.gif', array('id' => 'busy-indicator', 'style' => 'display:none'))."</big>";
        ?>
    </div>
    <?php echo $this->Js->writeBuffer(); ?>
</div>