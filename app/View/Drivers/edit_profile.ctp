<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <legend>Editar Perfil del Chofer <?php echo $driver['Driver']['username']?></legend>
        <div>
            <?php echo $this->Form->create('DriverProfile', array('type'=>'file')); ?>
            <fieldset>
                <?php
                echo $this->Form->input('id', array('type'=>'hidden'));
                echo $this->Form->input('driver_name', array('type'=>'text', 'label'=>'Nombre'));
                echo $this->Form->input('driver_nick', array('type'=>'text', 'label'=>'Nick (todo con minúscula, ej. martin-proenza-grm)'));
                echo $this->Form->input('driver_code', array('type'=>'text', 'label'=>'Código del chofer (max. 10 caracteres)', 'style'=>'text-transform:uppercase'));

                echo $this->Form->label('avatar');
                if(isset($this->request->data['DriverProfile'])) {
                    $src = '';
                    if(Configure::read('debug') > 0) $src .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien
                    $src .= '/'.str_replace('\\', '/', $this->request->data['DriverProfile']['avatar_filepath']);
                    echo '<img src="'.$src.'"/>';
                }
                echo $this->Form->file('avatar', array('label'=>'Avatar'));
                echo '<br/>';
                
                if(isset($this->request->data['DriverProfile']) &&  $this->request->data['DriverProfile']['featured_img_url'] != null) {
                    echo '<img class="img-responsive" style="max-width:200px" src="'.$this->request->data['DriverProfile']['featured_img_url'].'"/>';
                }
                echo $this->Form->input('featured_img_url', array('label'=>'Imagen destacada (url completa de la imagen)'));
                echo '<br/>';

                echo $this->Form->input('description_es', array('label'=>'Descripción Español'));
                echo $this->Form->input('description_en', array('label'=>'Description English'));
                echo $this->Form->checkbox('show_profile').' Mostrar Perfil';
                //echo $this->Form->file('resources', array('multiple'=>3));
                ?>
                <br/>
                <br/>
                <?php
                echo $this->Form->submit('Salvar');
                ?>
            </fieldset>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>