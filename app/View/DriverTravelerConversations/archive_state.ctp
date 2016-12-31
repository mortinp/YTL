<table class="table">
    <thead>
        <tr>
        <?php
            foreach($data as $tabla => $total)
                echo "<th>$tabla</th>";
        ?>
        </tr>
    </thead>
    
    <tbody>
        <tr>
        <?php
            foreach($data as $total)
                echo "<td>$total</td>";
        ?>
        </tr>
    </tbody>
</table>