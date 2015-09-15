<div style="float:left;padding-right:20px"><?php echo count($users)?> usuarios</div>
<table class='table table-striped table-hover'>
    <thead><th>ID</th><th>Usuario</th><th>Rol</th><th>Idioma</th><th>Viajes</th><th>Registro</th><th>IP Registro</th><th>Verificado</th></thead>
    <tbody> 
    <?php foreach ($users as $u): ?>
        <tr>
            <td><?php echo $u['User']['id']?></td>
            <td><?php echo $u['User']['username']?></td>
            <td><?php echo $u['User']['role']?></td>
            <td><?php echo $u['User']['lang']?></td>
            <td><?php echo $this->Html->link($u['User']['travel_count'], array('action'=>'view_travels/'.$u['User']['id']))?></td>
            <td><?php echo $u['User']['register_type']?></td>
            <td><?php echo $u['User']['registered_from_ip']?></td>
            <td><?php echo $u['User']['email_confirmed']?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>