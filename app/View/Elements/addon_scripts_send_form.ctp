<?php
// CSS
$this->Html->css('bootstrap', array('inline' => false));

//JS
$this->Html->script('jquery', array('inline' => false));
$this->Html->script('bootstrap', array('inline' => false));

$this->Html->script('jquery-validation-1.10.0/dist/jquery.validate.min', array('inline' => false));
$this->Html->script('jquery-validation-1.10.0/localization/messages_'.Configure::read('Config.language'), array('inline' => false));

echo $this->Js->writeBuffer(array('inline' => false));

?>

<script type="text/javascript">    
    $(document).ready(function() {        
        
        $('#<?php echo $formId?>').validate({
            wrapper: 'div',
            errorClass: 'text-danger',
            errorElement: 'div'
        });
        
        $('#<?php echo $formId?>').submit(function() {
            //if (!$(this).valid()) return false;

            $('#<?php echo $submitId?>').attr('disabled', true);
            $('#<?php echo $submitId?>').val('<?php echo __('Espera')?> ...');
        })
    })
</script>

<script type="text/javascript">
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
</script>