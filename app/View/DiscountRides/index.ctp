<?php App::uses('CakeTime', 'Utility')?>
<?php App::uses('TimeUtil', 'Util')?>
<?php $this->Html->css('font-awesome/css/font-awesome.css', array('inline' => false)); ?>

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h3>Viajes con descuento (<?php echo count($discountRides)?>)</h3>
            
            <div>Páginas: <?php echo $this->Paginator->numbers();?></div>
            <br/>           
        </div>
        <table class='table table-striped table-hover'>
            <thead><th>Chofer</th><th>Origen</th><th>Destino</th><th>Fecha</th><th>Total viajeros</th><th>Rango de salida</th><th>Activo?</th><th>Precio</th><th>Reservado</th></thead>
            <tbody> 
            <?php if(!empty ($discountRides)): ?>
                
                <br/>     
                <?php foreach ($discountRides as $conversation) :?>
                <?php
                $pretty_date = TimeUtil::prettyDate($conversation['DiscountRide']['date']);
                $date_converted = strtotime($conversation['DiscountRide']['date']);

                $expired = CakeTime::isPast($date_converted) && !CakeTime::isToday($date_converted);
                if($expired) $pretty_date .= ' <span class="badge">Expirado</span>';
                ?>
                <tr class="<?php if(!$conversation['DiscountRide']['active']) echo 'danger'; else if($conversation['DiscountRide']['is_booked']) echo 'info';?>">
                        <td>
                    <?php 
                        if(isset ($conversation['Driver']['DriverProfile']) && $conversation['Driver']['DriverProfile'] != null && !empty ($conversation['Driver']['DriverProfile'])) :?>
                            <?php
                                $src = '';
                                if(Configure::read('debug') > 0) $src .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien
                                $src .= '/'.str_replace('\\', '/', $conversation['Driver']['DriverProfile']['avatar_filepath']);
                            ?>
                            <img src="<?php echo $src?>" alt="<?php echo $conversation['Driver']['DriverProfile']['driver_name']?>" class="info" title="<?php echo $conversation['Driver']['DriverProfile']['driver_name']?>" style="max-height: 40px; max-width: 40px"/>
                        <?php endif;?>
                        </td>
                        <td>
                            <small><?php echo $conversation['DiscountRide']['origin']; ?></small>
                        </td>
                        <td>
                            <small><?php echo $conversation['DiscountRide']['destination']; ?></small>
                        </td>
                        <td>
                            <?php echo $pretty_date;?>
                        </td>
                        <td>
                            <?php echo $conversation['DiscountRide']['people_count']; ?>
                        </td>
                        <td>
                            <?php  echo TimeUtil::AmPm($conversation['DiscountRide']['hour_min']).' - '. TimeUtil::AmPm($conversation['DiscountRide']['hour_max']); ?>
                        </td>
                        <td>
                            <?php $mostrar = ($conversation['DiscountRide']['active']) ? "<div id='".$conversation['DiscountRide']['id']."' class='btn btn-warning btn-xs statechanger'>Desactivar <span class='fa fa-times'></span></div><input type='hidden' name='active".$conversation['DiscountRide']['id']."' id='active".$conversation['DiscountRide']['id']."' value='0'>" :  "<div id='".$conversation['DiscountRide']['id']."' class='btn btn-success btn-xs statechanger'>Activar <span class='fa fa-check'></span></div><input type='hidden' name='active".$conversation['DiscountRide']['id']."' id='active".$conversation['DiscountRide']['id']."' value='1'>"; echo $mostrar;?>
                        </td>
                        <td>
                          <?php echo "$ ".$conversation['DiscountRide']['price'] ?>  
                        </td>
                        <td>
                            <?php $mostrar = ($conversation['DiscountRide']['is_booked']) ? "<span class='fa fa-check'></span>" :  "<span class='fa fa-times'></span>"; echo $mostrar;?>
                        </td>
                        
                    </tr>                     
                <?php endforeach; ?>               

                <br/>

        <?php else :?>
            No hay viajes con descuentos
        <?php endif; ?>
        </tbody>
        </table>
            <div>Páginas: <?php echo $this->Paginator->numbers();?></div>
        
        
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