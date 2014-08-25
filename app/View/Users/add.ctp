<div class="users form">
    <?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend>Crear Usuario</legend>
        <?php
        echo $this->Form->input('username', array('type'=>'text'));
        echo $this->Form->input('password');
        echo $this->Form->input('role', array(
            'options' => array('regular' => 'Regular', 'admin' => 'Admin', 'tester'=>'Tester')
        ));
        echo $this->Form->submit(Salvar);
        ?>
    </fieldset>
<?php echo $this->Form->end(); ?>
</div>