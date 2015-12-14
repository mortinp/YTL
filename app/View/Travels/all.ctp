<?php 
if(!isset($actions)) $actions = false;
if(!isset($details)) $details = true;
?>
<div class="container">
    <div class="row">
    <?php if(!empty ($travels)): ?>
        <div class="col-md-6 col-md-offset-3">
            <h3>Anuncios de Viajes (<?php echo count($travels)?>)</h3>
            <div>Filtros: 
                <ul>
                <?php 
                    foreach (Travel::$filtersForSearch as $filter) {
                        echo '<li style="display:inline-block;padding-right:20px">';
                        
                        if(!isset ($filter_applied)) echo $this->Html->link($filter, array('action'=>'view_filtered/'.$filter));
                        else if($filter != $filter_applied) echo $this->Html->link($filter, array('action'=>'view_filtered/'.$filter));
                        else echo '<span class="badge"><big>'.$filter.'</big></span>';
                        
                        echo '</li>';
                    }
                ?>
                </ul>
            </div>
            
            <div>Páginas: <?php echo $this->Paginator->numbers();?></div>
            
            <br/>
            <?php
            
            // Contar la cantidad total de mensajes nuevos
            $newMsgCount = 0;
            $newTravelerMsgCount = 0;
            $followingCount = 0;
            if(!empty ($travels)) {
                foreach ($travels as $travel) {
                    foreach ($travel['DriverTravel'] as $conv) {
                        if(isset ($conv['TravelConversationMeta']) && $conv['TravelConversationMeta'] != null && !empty ($conv['TravelConversationMeta'])) {
                            $newMsgCount += $conv['driver_traveler_conversation_count'] - $conv['TravelConversationMeta']['read_entry_count'];
                            if($conv['TravelConversationMeta']['following']) $followingCount++;
                        }
                            
                        else $newMsgCount += $conv['driver_traveler_conversation_count'];
                        
                        if(isset ($conv['DriverTravelerConversation']) && $conv['DriverTravelerConversation'] != null && !empty ($conv['DriverTravelerConversation'])) {
                            if($conv['DriverTravelerConversation']['response_by'] === 'traveler') $newTravelerMsgCount ++;
                        }
                    }
                }
            }
            ?>
            <div>En esta página:                 
                <span class="label label-info" style="font-size: 12pt"><?php echo $followingCount.' siguiendo'?></span>
                <span class="label label-success" style="font-size: 12pt">+<?php echo $newMsgCount.' nuevos mensajes'?></span>
            </div>
            <br/>

            <?php if(!empty ($travels)): ?>                
                <br/>

                <ul style="list-style-type: none;padding: 0px">
                <?php foreach ($travels as $travel) :?>                
                    <li style="margin-bottom: 60px">
                        <?php echo $this->element('travel', array('travel'=>$travel, 'actions'=>$actions, 'details'=>$details))?>
                    </li> 
                <?php endforeach; ?>
                </ul>
                
                <br/>
            <?php endif; ?>
                
            <div>Páginas: <?php echo $this->Paginator->numbers();?></div>
        </div>

    <?php else :?>
        No hay anuncios de viajes
    <?php endif; ?>

    </div>
</div>

<?php
// CSS
$this->Html->css('bootstrap', array('inline' => false));
$this->Html->css('typeaheadjs-bootstrapcss/typeahead.js-bootstrap', array('inline' => false));

//JS
$this->Html->script('jquery', array('inline' => false));
$this->Html->script('bootstrap', array('inline' => false));
$this->Html->script('typeaheadjs/typeahead-martin', array('inline' => false));


$this->Js->set('drivers', $drivers);
echo $this->Js->writeBuffer(array('inline' => false));

?>

<script type="text/javascript">
    $(document).ready(function() {
        $('input.driver-typeahead').typeahead({
            valueKey: 'driver_id',
            local: window.app.drivers,
            template: function(datum) {
                var display = '';
                if(datum.driver_name != null) display += ' <b> ' + datum.driver_name + ' </b> | ';// Los espacios en las b son importantes para el matcheo
                display += ' ' + datum.driver_username;
                
                return display;
            }
        });
        
        $('input.tt-hint').addClass('form-control');
        $('.twitter-typeahead').css('display', 'block');
    });

</script>