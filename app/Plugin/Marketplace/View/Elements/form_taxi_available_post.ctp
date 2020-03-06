<?php App::uses('TaxiAvailablePost', 'Model');App::uses('TimeUtil', 'Util');?>

<?php
if(!isset($action)) $action = 'add';
?>

<div class="TaxiAvailablePost">
<?php echo $this->Form->create('TaxiAvailablePost', array('url' => array('action' =>$action), 'id'=>'MainForm')); ?>
    <fieldset>
        <div class="row">
            <div class="col-md-12">
                <?php echo $this->Form->input('date',array('type'=>'text','class'=>'datepicker', 'placeholder'=>'Click para seleccionar fecha', 'label'=>'Selecciona la fecha en que quedas libre:', 'autocomplete'=>'off', 'readonly'=>'readonly', 'dateFormat' => 'dd/mm/yyyy', 'required', 'invalid-feedback'=>__d('errors', 'Escriba una fecha válida en formato dd/mm/aaaa')));?>
            </div>
        </div>
        <br>
        
        <div class="row">
            <?php
            $localities = array();
            foreach (TaxiAvailablePost::$localities as $key => $l) {
                $localities[$key] = $l['name'];
            }
            ?>
            <div class="col-md-6">
                <?php echo $this->Form->input('origin_id', array('type'=>'select', 'options'=>$localities, 'label'=>'¿Dónde queda libre tu taxi?')); ?>
            </div>
            <div class="col-md-6">
                <?php echo $this->Form->input('destination_id', array('type'=>'select', 'options'=>$localities, 'label'=>'¿Hasta dónde puedes llevar pasajeros?')); ?>
            </div>
        </div>
        <br>
        
        <div class="row">            
            <?php 
            $hours24 = array();
            for ($i = 1; $i <= 24; $i++) {
                $hours24[$i] = TimeUtil::getTimeAmPM($i);
                
                /*if($i <= 12) $hours24[$i] = 'Mañana: '.$hours24[$i];
                else $hours24[$i] = 'Tarde: '.$hours24[$i];*/
            }
            ?>
            <div class="col-md-6">
                <?php echo $this->Form->input('time_available_start', array('type'=>'select', 'options'=>$hours24, 'selected'=>7, 'label'=>'Disponible a partir de:')); ?>
            </div>
            <div class="col-md-6">
                <?php echo $this->Form->input('time_available_end', array('type'=>'select', 'options'=>array(-1=>'Cualquier hora') + $hours24, 'label'=>'Disponible hasta:')); ?>                
            </div>
        </div>
        <br>
        
        <div class="row">
            <div class="col-md-12">
                <?php echo $this->Form->input('max_pax', array('label' => __d('shared_travels', 'Máx. cantidad de pasajeros'), 'value'=>3 ,'type'=>'number', 'default' => 3, 'min' => 1, 'required', 'invalid-feedback'=>__d('errors', 'La cantidad de personas debe ser un número entre {0} y {1}', 2, 4)));?>
            </div>
        </div>
        <br>
        
        <div class="row">
            <div class="col-md-6">
                <?php echo $this->Form->input('contact_name', array('label'=>'Tu nombre', 'required', 'invalid-feedback'=>__d('errors', 'El nombre es obligatorio')));?>
            </div>
            <div class="col-md-6">
                <?php echo $this->Form->input('contact_phone_number', array('label'=>'Teléfono (para llamadas y WhatsApp)', 'maxlength'=>8, 'addon-before'=>'<div class="input-group-prepend"><span class="input-group-text">+53</span></div>', 'required', 'invalid-feedback'=>__d('errors', 'El número de teléfono es obligatorio')));?>
            </div>
        </div>
    </fieldset>
    <br>
    <div class="row">
        <div class="col-md-12" style="padding-right: 40px">
            <?php echo $this->Form->submit(__('Publicar Taxi Disponible'),array('class'=>'btn btn-success btn-block', 'id'=>'MainFormSubmit')); ?>
        </div>
    </div>
    
</div>