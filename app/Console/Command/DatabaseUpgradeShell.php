<?php
    App::uses('UpgradeData', 'Util');

    class DatabaseUpgradeShell extends AppShell {
        public $uses = array('DriverTravel');
        public $cases;
        
        public function getOptionParser() {
            $parser = parent::getOptionParser();
            $parser->addSubCommand('archivar', array('help' => '--> archiva los datos') )
                   ->addSubCommand('restaurar', array('help' => '--> restaura los datos archivados') ) 
                   ->epilog( array("Ejemplos: ",
                                   "  cake DatabaseUpgrade archivar",
                                   "  cake DatabaseUpgrade restaurar") );
            return $parser;
        }

        public function __construct($stdout = null, $stderr = null, $stdin = null) {
            parent::__construct($stdout, $stderr, $stdin);
            $this->cases = new UpgradeData();
            
            /* --- Conversaciones no respondidas --- */
            $case1 = new UpgradeCase();
            $case1->set_query(
                            "select dt.id, tcm.conversation_id\n".
                            "from travels tr join drivers_travels dt on tr.id = dt.travel_id\n".
                                            "left join travels_conversations_meta tcm on dt.id = tcm.conversation_id\n".
                            "where (dt.driver_traveler_conversation_count = 0)  and\n".
                            "(tcm.conversation_id is null or tcm.following = 0) and\n".
	                    "(tcm.conversation_id is null or tcm.state = 'N')   and\n".
	                    "(datediff(current_date, tr.created) > 90)          and\n".
	                    "(current_date > tr.date)"
            );
                    
            $case1->add_table('travels_conversations_meta', 'conversation_id', 'conversation_id');
            $case1->add_table('drivers_travels', 'id', 'id');
            
            $this->cases->add($case1);
            
            /* --- Conversaciones que tienen un solo mensaje (el del chofer) --- */
            $case2 = new UpgradeCase();
            $case2->set_query(
                            "select dt.id, tcm.conversation_id, dtc.id as cid\n".
                            "from travels tr join drivers_travels dt on tr.id = dt.travel_id\n".
                                            "join driver_traveler_conversations dtc on dt.id = dtc.conversation_id\n".
			                    "left join travels_conversations_meta tcm on dt.id = tcm.conversation_id\n".
                            "where (dt.driver_traveler_conversation_count = 1)        and\n".
                                  "(dtc.response_by = 'driver')                       and\n".
                                  "(tcm.conversation_id is null or tcm.following = 0) and\n".
	                          "(tcm.conversation_id is null or tcm.state = 'N')   and\n".
	                          "(datediff(current_date, tr.created) > 90)          and\n".
	                          "(current_date > tr.date)"
            );
            
            $case2->add_table('travels_conversations_meta', 'conversation_id', 'conversation_id');
            $case2->add_table('driver_traveler_conversations', 'id', 'cid');
            $case2->add_table('drivers_travels', 'id', 'id');
                        
            $this->cases->add($case2);
        } 
        
        public function main(){}
        
        public function archivar(){
			// $this->$$this->argv[0]();
		
            $datasource = $this->DriverTravel->getDataSource();
            
            $caso = 1;
            foreach($this->cases->cases as $obj){
                $datasource->begin();
                
                $query = "create temporary table tmp_table ({$obj->query});\n";
                for($i = 0, $size = count($obj->tables); $i < $size; $i++){
                    $table    = $obj->tables[$i];
                    $id       = $obj->tables_ids[$i];
                    $query_id = $obj->query_ids[$i];
                    
                    $query .= "insert into archive_$table\n".
                              "(select * from $table\n".
                              "where $id in (select distinct $query_id from tmp_table) );\n".

                              "delete from $table\n".
                              "where $id in (select distinct $query_id from tmp_table);\n";
                }
                $query .= "drop table tmp_table;";

                try { 
                    $this->DriverTravel->query($query); 
                    $this->_UpdateCount();
                    $datasource->commit();    
                    $this->out("case $caso done!");
                    $caso++;
                }
                catch(Exception $error){
                    $datasource->rollback();
                    $this->out("case $caso fail!\n". $error->getMessage());
                    break;    
                }
            }    
        }
        
        public function restaurar(){
            $datasource = $this->DriverTravel->getDataSource();
            $datasource->begin();
            
            foreach($this->cases->table_id as $table => $id){
                $query = "insert into $table\n".
                         "(select * from archive_$table\n".
                         "where $id not in (select $id from $table) );\n".
                         
                         "delete from archive_$table;";
                
                try{ $this->DriverTravel->query($query); }
                catch(Exception $error){
                    $datasource->rollback();
                    $this->out("fail!\n". $error->getMessage());
                    return;
                }
            }          
            
            try{ $this->_UpdateCount(); }
            catch(Exception $error){
                $datasource->rollback();
                $this->out("fail!\n". $error->getMessage());
                return;
            }
            
            $datasource->commit();    
            $this->out("done!");
        }
        
        public function _UpdateCount(){
            $query = "update travels\n".
                     "set archive_conversations_count = (\n".
                        "select count(*) from archive_drivers_travels\n".
                        "where travels.id = archive_drivers_travels.travel_id".
                     ")";
            
            $this->DriverTravel->query($query);
        }
    }
?>
