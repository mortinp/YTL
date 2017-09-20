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
    <div class="col-md-8 col-md-offset-2">
        <?php
            echo "<center>".
                    $this->Paginator->next(
                        '+ '.__d('testimonials', 'Cargar más testimonios').'...',
                        array('escape'=> false, 'class'=>'btn btn-default'),
                        '<span class="text-muted">'.__d('testimonials', 'No hay más testimonios').'</span>',
                        array('escape'=> false)).
                "</center>";
            echo "<center><big>".$this->Html->image('loading.gif', array('id' => 'busy-indicator', 'style' => 'display:none'))."</big></center>";
        ?>
    </div>
    <?php echo $this->Js->writeBuffer(); ?>
</div>