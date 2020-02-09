<?php App::uses('CakeTime', 'Utility')?>
<?php App::uses('TimeUtil', 'Util')?>
<?php $this->Html->css('font-awesome/css/font-awesome.css', array('inline' => false)); ?>

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h3>Total de Actividades (<?php echo count($activities)?>)</h3>
            
            <div>Páginas: <?php /*echo $this->Paginator->numbers();*/?></div>
            <br/>
            <div><?php echo $this->Html->link('<i class="glyphicon glyphicon-plus-sign"></i> Nueva Actividad', array('action'=>'add'), array('escape'=>false))?></div>
        </div>
        <table class='table table-striped table-hover'>
            <thead><th>Descripción</th><th>Fecha</th><th>Choferes</th><th>Acciones</th><th>Compartir</th></thead>
            <tbody> 
            <?php if(!empty ($activities)): ?>
                
                <br/>     
                <?php foreach ($activities as $key=>$activity) :?>                
                <?php
                $pretty_date = TimeUtil::prettyDate($activity['Activity']['date']);
                $date_converted = strtotime($activity['Activity']['date']);

                $expired = CakeTime::isPast($date_converted) && !CakeTime::isToday($date_converted);
                if($expired) $pretty_date .= ' <span class="badge">Expirado</span>';
                ?>
                <tr class="info">                                               
                        <td>
                            <small><?php echo $activity['Activity']['name']; ?></small>
                        </td>
                        <td>
                            <?php echo $pretty_date;?>
                        </td> 
                        <td>
                            <?php foreach ($activity as $subscription): ?>
                            <?php if(isset($subscription['Driver'])): ?>
                            <span class="btn btn-xs btn-info" title="<?php echo "Hace el viaje por: $".$subscription['ActivityDriverSubscription']['price'] ?>"><b><?php echo $subscription['Driver']['DriverProfile']['driver_name'];?></b>&nbsp;<button class="close"><span aria-hidden="true">&times;</span></button></span>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </td>
                        <td>
                           <?php echo $this->Html->link('<i class="glyphicon glyphicon-plus-sign"></i> Chofer', array('action'=>'add_drivers/'.$key), array('escape'=>false))?> 
                        </td>
                        <td>
                           Poner en facebook 
                        </td>
                        
                    </tr>                     
                <?php endforeach; ?>               

                <br/>

        <?php else :?>
            No hay viajes con descuentos
        <?php endif; ?>
        </tbody>
        </table>
            <div>Páginas: <?php /*echo $this->Paginator->numbers();*/?></div>
        
        
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
        
                $(".statechanger").click(
                    function (event){                        
                        var value = $("input#active"+$(this).attr('id')).val();
                        var data ={'DiscountRide':{'active':value}};
                        $.ajax({
                            type: "POST",
                            data: data,
                            url: '<?php echo $this->Html->url(array('controller'=>'discount_rides', 'action'=>'edit/'))?>'+'/'+$(this).attr('id'),
                            success: function(response) {
                                //location.reload(true);
                                $('body').html(response);
                            }
                            
                        });
                       
                    }
                );
                
            });
        </script>

    </div>
</div>