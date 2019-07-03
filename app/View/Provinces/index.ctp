<div style="float:left"><?php echo $this->Html->link('<i class="glyphicon glyphicon-plus-sign"></i> Add New', array('action'=>'add'), array('escape'=>false))?></div>
<table class='table table-striped table-hover'>
    <thead><th>ID</th><th>Nombre</th><th></th></thead>
    <tbody> 
    <?php foreach ($provinces as $p): ?>
        <tr>
            <td><?php echo $p['Province']['id']?></td>
            <td><?php echo $p['Province']['name']?></td>
            <td>
                <ul class="list-inline">
                    <li><?php echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i> Editar', array('action'=>'edit/'.$p['Province']['id']), array('escape'=>false))?></li>
                    <li><?php echo $this->Html->link('<i class="glyphicon glyphicon-trash"></i> Eliminar', array('action'=>'remove/'.$p['Province']['id']), array('escape'=>false, 'confirm'=>'¿Está seguro que quiere eliminar esta provincia?'))?></li>
                </ul>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>