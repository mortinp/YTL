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
        <div class="col-md-12">
        <?php if(!empty ($activities)): ?>
        <?php foreach ($activities as $key=>$activity) :?>  
        <div class="well">  
                <?php
                $pretty_date = TimeUtil::prettyDate($activity['Activity']['date']);
                $date_converted = strtotime($activity['Activity']['date']);

                $expired = CakeTime::isPast($date_converted) && !CakeTime::isToday($date_converted);
                if($expired) $pretty_date .= ' <span class="badge">Expirado</span>';
                ?>
            <h4><?php echo $activity['Activity']['name']; ?></h4>
        
          <?php echo $this->Html->link('<i class="glyphicon glyphicon-plus-sign"></i> Chofer', array('action'=>'add_drivers/'.$key), array('escape'=>false))?> 
       
             <table class='table table-striped table-hover'>
            <thead><th>Fecha</th><th>Chofer</th><th>Precio</th><th>Acciones</th><th>Compartir</th></thead>            
             <tbody>
                <?php foreach ($activity as $subscription): ?>
            <?php if(isset($subscription['Driver'])): ?>
          
                <tr>
            <td>
                <?php echo $pretty_date;?>
                    </td>
                    <td>
                        <b><?php echo $subscription['Driver']['DriverProfile']['driver_name'];?></b>
                    </td>
                    <td>
                        <?php echo $subscription['ActivityDriverSubscription']['price'] ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link('<span class="btn btn-xs btn-info"><button class="close"><span aria-hidden="true">&times;</span></button></span>', array('action'=>'remove_driver/'.$subscription['ActivityDriverSubscription']['id']), array('escape'=>false))?>
                    </td>
                    <td>

                    </td>
                </tr> 
                <?php else: ?>
                <p>No hay choferes subscritos</p>
            
               <?php endif; ?>
              <?php endforeach; ?>
                </tbody>
           </table> 
            
          </div>                          
        <?php endforeach; ?>               

               
        
        <?php else :?>
            No hay viajes con descuentos
        <?php endif; ?>
        </div>    
        
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