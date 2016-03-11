<?php $casasExpert = Configure::read('casas_expert')?>

<div class="container">
<div class="row">
    <div class="col-md-8 col-md-offset-2 well form-cover" id="casas-request-create" style="padding-left: 100px">
        <?php echo $this->Session->flash('auth'); ?>
        
        <legend style="text-align:center">
            <div class="handwritten-2"><big><big><?php echo __d('casas', 'Reserva casas particulares en Cuba para quedarte en los lugares que vas a visitar') ?></big></big></div>
            <div><small><?php echo __d('casas', 'Solicita la ayuda de un experto para que encuentres las mejores opciones.') ?></small></div>
        </legend>
        
        <div> <div style="float: left;margin-left: -80px"><?php echo $this->Html->image($casasExpert['avatar_path'])?></div> <div><?php echo __d('casas', '%s y su equipo trabajarán junto contigo para encontrar casas. Comienza enviándoles los siguientes datos', $casasExpert['name'])?>:</div></div>
        
        <br/>        
        <div>
            <?php echo $this->Form->create('CasaFindRequest', array('id'=>'CasaFindRequestForm')); ?>
            <fieldset>
                <?php
                echo $this->Form->input('guests_names', array('label' => __d('casas', 'Nombres de los huéspedes <small>&ndash; ej. Nancy, Mario, Claudia y Emilio</small>'), 'type' => 'text', 'autofocus'=>true));
                echo $this->Form->input('details', array('label' => __d('casas', 'Detalles de lo que necesitas').' <small><abbr class="info" title="'.__d('casas', '<p>Somos 4 personas, necesitaremos 2 habitaciones</p><p>21/05/2015: La Habana, 2 noches</p></p><p>23/05/2015: Viñales, 1 noche</p></p><p>24/05/2015: Trinidad, 2 noches</p><p>[Puedes adicionar cualquier otra cosa que necesites decirle al experto]</p>').'">'.__d('casas', 'ver ejemplo de detalles').'</abbr></small>', 'type' => 'textarea', 'placeholder'=>__d('casas', 'Incluye datos como lugares donde necesitas casas, fechas y cuántas habitaciones necesitarás')));

                $buttonStyle = 'font-size:18pt;white-space: normal;';
                $submitOptions = array('style' => $buttonStyle, 'id'=>'CasaFindRequestSubmit', 'escape'=>false, 'rel'=>'nofollow');
                $saveButtonText = __d('casas', 'Comenzar la búsqueda de casas ahora').' <div style="font-size:12pt;padding-left:50px;padding-right:50px">'.__d('casas', 'Le enviaremos tu correo electrónico a %s para que te contacte directamente', $casasExpert['name']).'</div>';
                ?>           

                <div style="text-align: center">
                <?php echo $this->Form->submit($saveButtonText, $submitOptions, true);?>
                </div>
            </fieldset>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
</div>

<?php
//JS
$this->Html->script('jquery', array('inline' => false));
$this->Html->script('bootstrap', array('inline' => false));

$this->Html->script('jquery-validation-1.10.0/dist/jquery.validate.min', array('inline' => false));
$this->Html->script('jquery-validation-1.10.0/localization/messages_'.Configure::read('Config.language'), array('inline' => false));

echo $this->Js->writeBuffer(array('inline' => false));

?>
<script type="text/javascript">    
    $(document).ready(function() {        
        $('#CasaFindRequestForm').validate({
            wrapper: 'div',
            errorClass: 'text-danger',
            errorElement: 'div'
        });
    })
</script>

<script type="text/javascript">
    //<![CDATA[
    function get_form( element )
    {
        while( element )
        {
            element = element.parentNode
            if( element.tagName.toLowerCase() == "form" ) {
                return element
            }
        }
        return 0; //error: no form found in ancestors
    }
    //]]>
</script>
