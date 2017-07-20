<?php
    App::uses('UpgradeCase', 'Util');

    class DatabaseUpgradeShell extends AppShell {
        public $uses = array('DriverTravel');
        public $case;
        
        public function getOptionParser() {
            $casos = array('conversaciones_no_respondidas', 'conversaciones_solo_mensaje_del_chofer');
            $parser_arch['arguments']['archivar'] = array( 'help'     => '--> archiva los datos',
                                                           'choices'  => $casos,
                                                           'required' => true ); 
            $parser_rest['arguments']['restaurar'] = array( 'help'     => '--> restaura los datos archivados',
                                                            'choices'  => $casos,
                                                            'required' => true );
            
            $parser = parent::getOptionParser();
            $parser->addSubcommand('archivar', array('help'     => '--> archiva los datos',
                                                     'parser'  => $parser_arch)
                                 )
                   ->addSubcommand('restaurar', array('help'    => '--> restaura los datos archivados',
                                                      'parser'  => $parser_rest)
                                ) 
                   ->epilog( array("Ejemplos: ",
                                   "  cake DatabaseUpgrade archivar conversaciones_no_respondidas",
                                   "  cake DatabaseUpgrade restaurar conversaciones_solo_mensaje_del_chofer") );
            return $parser;
        }

        public function main(){ }
        
        /*---------------------------- INTERFACE ----------------------------*/
        public function archivar(){
           $caso = $this->args[0];
           $this->$caso();
           
           if( $this->_move(true) )  $this->out ("done case: $caso");
           else                      $this->out ("fail in case: $caso");
        }
        
        public function restaurar(){
           $caso = $this->args[0];
           $this->$caso('archive_');
           
           if( $this->_move(false) )  $this->out ("done case: $caso");
           else                       $this->out ("fail in case: $caso");
        }
        
        /*---------------------------- CORE ----------------------------*/
        public function _UpdateCount(){
            $query = "update travels\n".
                     "set archive_conversations_count = (\n".
                        "select count(*) from archive_drivers_travels\n".
                        "where travels.id = archive_drivers_travels.travel_id".
                     ")";
            
            $this->DriverTravel->query($query);
        }
        
        public function _move($archive){
            $datasource = $this->DriverTravel->getDataSource();
            $datasource->begin();
            $obj = $this->case;

            $query = "create temporary table tmp_table ({$obj->query});\n";
            for($i = 0, $size = count($obj->tables); $i < $size; $i++){
                $table    = $obj->tables[$i];
                $id       = $obj->tables_ids[$i];
                $query_id = $obj->query_ids[$i];
                $from     = ($archive) ? "$table"         : "archive_$table";
                $to       = ($archive) ? "archive_$table" : "$table";


                $query .= "insert into $to\n".
                          "(select * from $from\n".
                          "where $id in (select distinct $query_id from tmp_table) );\n".

                          "delete from $from\n".
                          "where $id in (select distinct $query_id from tmp_table);\n";
            }
            $query .= "drop table tmp_table;";

            try { 
                $this->DriverTravel->query($query); 
                $this->_UpdateCount();
                $datasource->commit();    
                return true;
            }
            catch(Exception $error){
                $datasource->rollback();
                $this->out( $error->getMessage() );
                return false;
            }
        }
        
        /*---------------------------- CASES ----------------------------*/
        private function conversaciones_no_respondidas($archive = ''){
            $this->case = new UpgradeCase();
            $this->case->set_query(
                            "select dt.id, tcm.conversation_id\n".
                            "from travels tr join {$archive}drivers_travels dt on tr.id = dt.travel_id\n".
                                            "left join {$archive}travels_conversations_meta tcm on dt.id = tcm.conversation_id\n".
                            "where (dt.message_count = 0)  and\n".
                            "(tcm.conversation_id is null or tcm.following = 0) and\n".
	                    "(tcm.conversation_id is null or tcm.state = 'N')   and\n".
	                    "(datediff(current_date, tr.created) > 90)          and\n".
	                    "(current_date > tr.date)"
            );
                    
            $this->case->add_table('travels_conversations_meta', 'conversation_id', 'conversation_id');
            $this->case->add_table('drivers_travels', 'id', 'id');
        }
        
        private function conversaciones_solo_mensaje_del_chofer($archive = ''){
            $this->case = new UpgradeCase();
            $this->case->set_query(
                            "select dt.id, tcm.conversation_id, dtc.id as cid\n".
                            "from travels tr join {$archive}drivers_travels dt on tr.id = dt.travel_id\n".
                                            "join {$archive}driver_traveler_conversations dtc on dt.id = dtc.conversation_id\n".
			                    "left join {$archive}travels_conversations_meta tcm on dt.id = tcm.conversation_id\n".
                            "where (dt.message_count = 1)        and\n".
                                  "(dtc.response_by = 'driver')                       and\n".
                                  "(tcm.conversation_id is null or tcm.following = 0) and\n".
	                          "(tcm.conversation_id is null or tcm.state = 'N')   and\n".
	                          "(datediff(current_date, tr.created) > 90)          and\n".
	                          "(current_date > tr.date)"
            );
            
            $this->case->add_table('travels_conversations_meta', 'conversation_id', 'conversation_id');
            $this->case->add_table('driver_traveler_conversations', 'id', 'cid');
            $this->case->add_table('drivers_travels', 'id', 'id');
        }
    }
?>
