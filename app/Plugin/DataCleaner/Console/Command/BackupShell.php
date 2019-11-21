<?php

App::uses('AppShell', 'Console/Command');
App::uses('DataCleanerController', 'DataCleaner.Controller');

class BackupShell extends AppShell {

    public function getOptionParser() {
        $parser = parent::getOptionParser();
        $parser
                ->description('Backups the data from original database');
//                ->addOption('limit', array(
//                    'short' => 'l',
//                    'help' => 'How many emails should be sent in this batch?',
//                    'default' => 50
//                ));
        return $parser;
    }

    /**
     * Backup old data
     *
     * @access public
     */
    public function main() {
        Configure::write('App.baseUrl', '/');
        //$backup = ClassRegistry::init('DataCleaner.DataCleanerController');
        $backup = new DataCleanerController();
        try{
        $backup->backup();
        }catch(Exception $error){
            $this->out( $error->getMessage() );
        }
        
        
    }

    

}