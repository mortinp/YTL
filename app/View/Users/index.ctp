<div style="float:left;padding-right:20px"><?php echo count($users)?> usuarios</div>
<div><?php echo $this->Html->link('Nuevo usuario', array('action'=>'add'))?></div>
<br/>
<div>Páginas: <?php echo $this->Paginator->numbers();?></div>
<br/>
<table class='table table-striped table-hover'>
    <thead><th></th><th>ID</th><th>Usuario</th><th>Nombre</th><th>Rol</th><th>Idioma</th><th>Viajes</th><th>Verificado</th><th>Registro</th><th>IP Registro</th></thead>
    <tbody> 
    <?php foreach ($users as $u): ?>
        <tr>
            <td>
                <div><?php echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i> Editar', array('action'=>'edit', $u['User']['id']), array('escape'=>false))?></div>
                <div><?php echo $this->Html->link('admin »', array('action'=>'admin', $u['User']['id']))?></div>
            </td>
            <td><?php echo $u['User']['id']?></td>
            <td><?php echo $u['User']['username']?></td>
            <td><?php echo $u['User']['display_name']?></td>
            <td><?php echo $u['User']['role']?></td>
            <td><?php echo $u['User']['lang']?></td>
            <td><?php echo $this->Html->link($u['User']['travel_count'], array('action'=>'view_travels/'.$u['User']['id']))?></td>
            <td><?php echo $u['User']['email_confirmed']?></td>
            <td><?php echo $u['User']['register_type']?></td>
            <td><?php echo $u['User']['registered_from_ip']?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div>Páginas: <?php echo $this->Paginator->numbers();?></div>