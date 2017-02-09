<?php /* -- params -- 
 * -> $testimonial 
 */ ?>

<?php
$urlConversation = array('controller' => 'driver_traveler_conversations', 'action' => 'view', $testimonial['conversation_id']);

$statesStr = array('P' => 'Pendiente', 'A' => 'Aprobado', 'R' => 'Rechazado');
$statesClasses = array('P' => 'btn-default', 'A' => 'btn-success', 'R' => 'btn-danger');

$idiomas = array('es' => 'Español',
    'en' => 'Inglés');
$action = $this->request->params['action'];
?>

<div class="panel">
    <table class="table table-condensed">
        <thead>
            <tr>
                <th>Estado</th>
                <th>Idioma <small class="text-muted">(cambiar si es otro)</small></th>
                <th>Creado</th>
                <th>Modificado</th>
                <th><?php echo ( ($testimonial['conversation_id']) ? "Conversación" : "Email"); ?></th>
                <th>
                    <?php 
                    if($testimonial['featured']) echo $this->Form->button('Quitar featured', array('class'=>'btn-danger btn-sm', 'action'=>'unset_featured/'.$testimonial['id']), true);
                    else echo $this->Form->button('Poner featured', array('class'=>'btn-info btn-sm', 'action'=>'set_featured/'.$testimonial['id']), true);
                    ?>
                </th>
            </tr>    
        </thead> 

        <tbody>
            <tr>
                <!-- Estado -->
                <td>
                    <div class="btn-group" style="cursor: pointer">
                        <span class="<?php echo $statesClasses[$testimonial['state']]; ?>" data-toggle="dropdown" style="display: table-cell">
                            <?php echo $statesStr[$testimonial['state']]; ?>
                            <i class="caret"></i>
                        </span>

                        <div class="dropdown-menu">
                            <?php
                            foreach ($statesStr as $clave => $valor)
                                if ($testimonial['state'] != $clave)
                                    echo $this->Form->button("$valor", array('class' => "btn-block {$statesClasses[$clave]}", 'action' => "state_change/{$testimonial['id']}/$clave/$action"), true);
                            ?>
                        </div>
                    </div>
                </td>

                <!-- Idioma -->
                <td>
                    <div class="btn-group" style="cursor: pointer">
                        <span data-toggle="dropdown">
                            <?php echo $idiomas[$testimonial['lang']]; ?>
                            <i class="caret"></i>
                        </span>

                        <div class="dropdown-menu" style="min-width: 50px">
                            <?php
                            foreach ($idiomas as $clave => $valor)
                                if ($testimonial['lang'] != $clave)
                                    echo $this->Form->button("$valor", array('escape' => false, 'action' => "lang_change/{$testimonial['id']}/$clave/$action"), true);
                            ?>
                        </div>
                    </div>
                </td>    

                <!-- Creado -->
                <td><?php echo $testimonial['created']; ?></td>

                <!-- Modificado -->
                <td><?php
                            if ($testimonial['modified'] != $testimonial['created'])
                                echo "<span class='label label-warning'>{$testimonial['modified']}</span>";
                            else
                                echo $testimonial['modified'];
                            ?>
                </td>

                <!-- Conversación -->
                <td>
                        <?php if ($testimonial['conversation_id']): ?>  
                        <a href="<?php echo $this->html->url($urlConversation, true); ?>" title="Ver Conversación">
                        <?php echo $testimonial['conversation_id']; ?>
                        </a>
                    <?php
                    else:
                        echo $testimonial['email'];
                    endif;
                    ?>  
                </td>
            </tr>    
        </tbody>
    </table>
</div>