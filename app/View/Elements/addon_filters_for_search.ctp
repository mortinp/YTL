<div> 
    <ul>
    <?php 
        foreach ($filters_for_search as $filter) {
            echo '<li style="display:inline-block;padding-right:20px">';

            if(!isset ($filter_applied)) echo $this->Html->link($filter, array('action'=>'view_filtered/'.$filter));
            else if($filter != $filter_applied) echo $this->Html->link($filter, array('action'=>'view_filtered/'.$filter));
            else echo '<span class="badge"><big><big><big>'.$filter.'</big></big></big></span>';

            echo '</li>';
        }
    ?>
    </ul>
</div>