<?php 
//die(print_r($discountRides));
if(!isset($actions)) $actions = false;
if(!isset($details)) $details = true;
?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h3>Viajes con descuento (<?php echo count($discountRides)?>)</h3>
            
            <div>Páginas: <?php echo $this->Paginator->numbers();?></div>
            <br/>           
        </div>
        <div class="col-md-8 col-md-offset-2">
            <?php if(!empty ($discountRides)): ?>
                <br/>
                <br/>        

                <ul style="list-style-type: none;padding: 0px">
                <?php foreach ($discountRides as $dt) :?>
                    <li style="margin-bottom: 60px">
                        <?php echo $this->element('discount_travel_widget', array('conversation'=>$dt));?>
                    </li> 
                <?php endforeach; ?>
                </ul>

                <br/>

        <?php else :?>
            No hay viajes con descuentos
        <?php endif; ?>
            <div>Páginas: <?php echo $this->Paginator->numbers();?></div>
        </div>
        
        <!-- all .open-form opens in a bootbox -->
        <?php
            $this->Html->css('bootstrap', array('inline' => false));
            $this->Html->css('vitalets-bootstrap-datepicker/datepicker.min', array('inline' => false));

            $this->Html->script('jquery', array('inline' => false));
            $this->Html->script('bootstrap', array('inline' => false));
            $this->Html->script('bootbox/bootbox', array('inline' => false));
            $this->Html->script('vitalets-bootstrap-datepicker/bootstrap-datepicker.min', array('inline' => false));

            echo $this->Js->writeBuffer(array('inline' => true));
        ?>
        
        <script type="text/javascript"> 
            $(document).ready(function(){
                $(".open-form").click(
                    function (event){
                        bootbox.dialog({title:$(this).data('title'), message:$( '#' + $(this).data('form') ).html()});
                        event.preventDefault();
                    }
                );
            });
        </script>

    </div>
</div>