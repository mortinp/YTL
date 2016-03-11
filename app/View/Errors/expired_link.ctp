<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h2><?php echo $name; ?></h2>
        <p class="error">
            <strong><?php echo __d('error', 'Error'); ?>: </strong>
            <?php
            printf(__d('error', 'Ocurrió un error usando este enlace. Puede ser que esté caducado, ya haya sido usado o es incorrecto.'));
            ?>
        </p>
    </div>
</div>

<?php
if (Configure::read('debug') > 0):
    echo $this->element('exception_stack_trace');
endif;
?>
