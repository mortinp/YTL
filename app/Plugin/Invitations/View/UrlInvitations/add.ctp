<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <legend>Adicionar una invitación a una url</legend>
        <span class="alert alert-warning" style="display: inline-block"><i class="glyphicon glyphicon-warning-sign"></i> Si se envía una de estas invitaciones a alguna persona, esta url se va a poder acceder sin tener que loguearse. Tener CUIDADO!!!</span>
        <div>
            <?php echo $this->Form->create('UrlInvitation'); ?>
            <fieldset>
                <?php
                echo $this->Form->input('url', array('label'=>'Url <span class="small">ej. /metrics/dashboard</span>'));
                echo $this->Form->input('action_to_allow', array('label'=>'Acción <span class="small">(la acción del controlador que se debe permitir, ej. dashboard)'));
                echo $this->Form->input('allowed_visits_count', array('label'=>'Veces que se debe permitir revisar la url', 'default' => 1, 'min' => 1));
                echo $this->Form->input('comments', array('label'=>'Comentario (ej. por qué y para quién es esta invitación)'));
                echo $this->Form->submit('Crear');
                ?>
            </fieldset>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>