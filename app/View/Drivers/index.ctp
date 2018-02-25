<div>
    
    <!-- Resumen de cantidad de testimonios por choferes -->
    <div>
        <b>Choferes activos por provincias:</b>
        <?php
        $results = array();
        foreach($drivers as $d) {
            if(!array_key_exists($d['Province']['id'], $results)) {
                $subject = $d['Province']['id'];
                $count = 0;
                foreach($drivers as $again) {
                    if($again['Driver']['active'] && $again['Driver']['receive_requests'] && $again['Driver']['role'] == 'driver' && $again['Province']['id'] == $subject) $count ++;
                }
                $results[$subject] = array(
                    'province_name' => $d['Province']['name'],
                    'drivers_count'=>$count);
            }
        } 
        ?>

        <ul class="list-inline">
        <?php foreach($results as $r):?>
            <li><?php echo $r['province_name']?> (<?php echo $r['drivers_count']?>)</li>
        <?php endforeach?>
        </ul>
        <hr/>
    </div>
    
</div>

<div style="float:left;padding-right:20px"><?php echo count($drivers)?> choferes</div>
<div style="float:left"><?php echo $this->Html->link('<i class="glyphicon glyphicon-plus-sign"></i> Nuevo Chofer', array('action'=>'add'), array('escape'=>false))?></div>
<table class='table table-striped table-hover'>
    <thead><th></th><th>ID</th><th>Código</th><th>Correo</th><th>PAX</th><th>Moderno</th><th>A/C</th><th>Inglés</th><th>Descripción</th><th>Provincia</th><th>Localidades</th><th>Operador</th><th>Fecha Registro</th></thead>
    <tbody> 
    <?php foreach ($drivers as $d): ?>
        <?php $hasProfile = isset($d['DriverProfile']) && !empty ($d['DriverProfile']) && $d['DriverProfile']['driver_nick'] != null?>
        
        <tr class="<?php if(!$d['Driver']['active']) echo "danger";else if(!$d['Driver']['receive_requests']) echo "info"?>">
            <td>
                <ul class="list-inline">
                    <li><?php echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i> Editar', array('action'=>'edit/'.$d['Driver']['id']), array('escape'=>false))?></li>
                    <li><?php echo $this->Html->link('<i class="glyphicon glyphicon-user"></i> Editar Perfil', array('action'=>'edit_profile/'.$d['Driver']['id']), array('escape'=>false))?></li>
                    <?php if($d['Driver']['role'] == 'driver_tester'):?>
                        <li><?php echo $this->Html->link('<i class="glyphicon glyphicon-trash"></i> Eliminar', array('action'=>'remove/'.$d['Driver']['id']), array('escape'=>false))?></li>                    
                    <?php endif;?>
                    <hr/>
                    <li><?php echo $this->Html->link('admin »', array('action'=>'admin', $d['Driver']['id']))?></li>
                </ul>
            </td>
            
            <td><?php echo $d['Driver']['id']?></td>
            <td>
                <?php if($hasProfile):?>
                    <span class="info" title="Esto es un código personal de cada chofer, que usan para que sus clientes pongan testimonios sobre ellos en el sitio.">
                    <?php if($d['DriverProfile']['driver_code']):?>
                        <?php echo strtoupper($d['DriverProfile']['driver_code'])?>
                    <?php else:?>
                        <code>¿CODIGO?</code>
                    <?php endif?>
                    </span>
                <?php else:?>
                    <code>¿CODIGO?</code>
                <?php endif;?>
            </td>
            <td>
                <?php echo $d['Driver']['username']?>
                <div><?php echo $this->Html->link('<i class="glyphicon glyphicon-picture"></i> Ver Perfil', array('action'=>'profile/'.$d['DriverProfile']['driver_nick']), array('escape'=>false))?></div>
                <div><?php echo $this->Html->link($d['Driver']['travel_count'].' viajes', array('action'=>'view_travels/'.$d['Driver']['id']))?></div>
            </td>
            <td><?php echo $d['Driver']['min_people_count']?> - <?php echo $d['Driver']['max_people_count']?></td>
            <td><?php echo $d['Driver']['has_modern_car']?></td>
            <td><?php echo $d['Driver']['has_air_conditioner']?></td>
            <td><?php echo $d['Driver']['speaks_english']?></td>
            <td><?php echo $d['Driver']['description']?></td>
            <td><?php echo $d['Province']['name']?></td>
            <td>
                <?php 
                $sep = '';
                foreach ($d['Locality'] as $l) {
                    echo $sep.$l['name'];
                    $sep = ', ';
                }
                ?>
            </td>
            <td><?php echo User::prettyName($d['User'])?></td>
            <td><?php echo $d['Driver']['created']?></td>
            
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php ?>