<?php /* -- params -- 
 * -> $testimonial 
 */ ?>

<?php
$urlConversation = array('controller' => 'driver_traveler_conversations', 'action' => 'view', $testimonial['conversation_id']);

$statesStr = array('P' => 'Pendiente', 'A' => 'Aprobado', 'R' => 'Rechazado');
$statesClasses = array('P' => 'btn-default', 'A' => 'btn-success', 'R' => 'btn-danger');


$action = $this->request->params['action'];
?>

<div class="panel">
    <table class="table table-condensed">
        <thead>
            <tr>
                <th>Estado</th>                
                <th>Creado</th>                    
            </tr>    
        </thead> 

        <tbody>
            <tr>
                <!-- Estado -->
                <td>
                    <div class="btn-group" style="cursor: pointer">
                        <span class="<?php echo $statesClasses[$reply['state']]; ?>" data-toggle="dropdown" style="display: table-cell">
                            <?php echo $statesStr[$reply['state']]; ?>
                            <i class="caret"></i>
                        </span>

                        <div class="dropdown-menu">
                            <?php
                            foreach ($statesStr as $clave => $valor)
                                if ($reply['state'] != $clave)
                                    echo $this->Form->button("$valor", array('class' => "btn-block {$statesClasses[$clave]}", 'action' => "reply_state_change/{$reply['id']}/$clave/$action"), true);
                            ?>
                        </div>
                    </div>
                </td>               

                <!-- Creado -->
                <td><?php echo $testimonial['created']; ?></td>               

                
            </tr>    
        </tbody>
    </table>
</div>