<div style="float:left;padding-right:20px"><?php echo count($drivers)?> choferes</div>
<div style="float:left"><?php echo $this->Html->link('<i class="glyphicon glyphicon-plus-sign"></i> Add New', array('action'=>'add'), array('escape'=>false))?></div>
<table class='table table-striped table-hover'>
    <thead><th></th><th>ID</th><th>Correo</th><th>PAX</th><th>Moderno</th><th>A/C</th><th>Inglés</th><th>Descripción</th><th>Localidades</th><th>Viajes</th></thead>
    <tbody> 
    <?php foreach ($drivers as $d): ?>
        <tr class="<?php if(!$d['Driver']['active']) echo "danger";?>">
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
                <?php echo $d['Driver']['username']?>
                <?php if(isset($d['DriverProfile']) && !empty ($d['DriverProfile']) && $d['DriverProfile']['driver_nick'] != null):?>
                    <div><?php echo $this->Html->link('<i class="glyphicon glyphicon-picture"></i> Ver Perfil', array('action'=>'profile/'.$d['DriverProfile']['driver_nick']), array('escape'=>false))?></div>
                <?php endif;?>
            </td>
            <td><?php echo $d['Driver']['min_people_count']?> - <?php echo $d['Driver']['max_people_count']?></td>
            <td><?php echo $d['Driver']['has_modern_car']?></td>
            <td><?php echo $d['Driver']['has_air_conditioner']?></td>
            <td><?php echo $d['Driver']['speaks_english']?></td>
            <td><?php echo $d['Driver']['description']?></td>
            <td>
                <?php 
                $sep = '';
                foreach ($d['Locality'] as $l) {
                    echo $sep.$l['name'];
                    $sep = ', ';
                }
                ?>
            </td>
            <td><?php echo $this->Html->link($d['Driver']['travel_count'], array('action'=>'view_travels/'.$d['Driver']['id']))?></td>
            
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php ?>