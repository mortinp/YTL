<div><?php echo $this->Paginator->numbers(array('modulus'=>20));?></div>
<table class='table table-striped table-hover'>
    <thead>
        <th>id</th>
        <th>conversation_id</th>
        <th>msg_id</th>
        <th>created</th>
        
        <th>identifier</th>
        <th>driver_id</th>
        
        <th>sync_date</th>
        <th>batch_id</th>
    </thead>
    <tbody> 
    <?php foreach ($queue as $q): ?>
        <tr>
            <td><?php echo $q['SyncObject']['id']?></td>
            <td><?php echo $q['SyncObject']['conversation_id']?></td>
            <td><?php echo $q['SyncObject']['msg_id']?></td>
            <td><?php echo $q['SyncObject']['created']?></td>
            
            <td><?php if($q['DriverTravel']['travel_id'] != null) echo $q['DriverTravel']['travel_id']; else echo 'D'.$q['DriverTravel']['identifier']?></td>
            <td><?php echo $q['DriverTravel']['driver_id']?></td>
            
            <td><?php echo $q['SyncObject']['sync_date']?></td>
            <td><?php echo $q['SyncObject']['batch_id']?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>