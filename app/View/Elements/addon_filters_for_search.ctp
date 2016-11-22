<div> 
    <ul class="list-inline">
    <?php 
        foreach ($filters_for_search as $key=>$filter) {
            echo '<li>';
            
            $label = $filter;
            $title = null;
            $search = $filter;
            if(is_array($filter)) {
                if(isset ($filter['label'])) $label = $filter['label'];
                if(isset ($filter['title'])) $title = $filter['title'];
                $search = $key;
            }

            if(!isset ($filter_applied)) echo '<kbd class="info", title="'.$title.'">'.$this->Html->link($label, array('action'=>'view_filtered/'.$search), array('style'=>'color: white', 'escape'=>false)).'</kbd>';
            else if($search != $filter_applied) echo '<kbd class="info", title="'.$title.'">'.$this->Html->link($label, array('action'=>'view_filtered/'.$search), array('style'=>'color: white', 'escape'=>false)).'</kbd>';
            else echo '<big><big><big><code>'.$label.'</code></big></big></big>';

            echo '</li>';
        }
    ?>
    </ul>
</div>