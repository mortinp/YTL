<?php
   class UpgradeCase{
       public $query, $tables, $tables_ids, $query_ids;
       
       public function set_query($query){
           $this->query = $query;           
       }
       
       public function add_table($table, $id, $query_id){
           $this->tables[]     = $table;
           $this->tables_ids[] = $id;
           $this->query_ids[] = $query_id;
       }
   }
?>
