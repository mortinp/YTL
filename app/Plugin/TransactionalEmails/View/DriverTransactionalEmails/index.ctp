<table class='table table-striped table-hover'>
    <thead><th>ID</th><th>Chofer</th><th>Tipo</th><th>Ultimo envío</th></thead>
    <tbody> 
    <?php foreach ($emails_sent as $e): ?>
        <tr>
            <td><?php echo $e['DriverTransactionalEmail']['id']?></td>
            <td><?php echo $e['Driver']['username']?></td>
            <td><?php echo $e['DriverTransactionalEmail']['transaction_type']?></td>
            <td><?php echo $e['DriverTransactionalEmail']['last_sent']?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>