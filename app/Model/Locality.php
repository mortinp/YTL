<?php
App::uses('AppModel', 'Model');
App::uses('LocalityThesaurus', 'Model');

class Locality extends AppModel {
    
    public $order = 'Locality.id';
    
    public $hasAndBelongsToMany = 'Driver';
    
    public $belongsTo = array(
        'Province' => array(
            'fields'=>array('id', 'name')
        )
    );
    
    public $validate = array(
        'name' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'El nombre es obligatorio.'
            )
        ) 
    );
    
    public function getAsList() {        
        $localities = Cache::read('localities');
        if (!$localities) {
            $localities = $this->find('list', array(
                "fields" => array("Locality.id", "Locality.name", "Province.name"),
                "joins" => array(
                    array(
                        "table" => "provinces",
                        "alias" => "Province",
                        "type" => "INNER",
                        "conditions" => array("Province.id = Locality.province_id")
                    )
                )
            ));
            Cache::write('localities', $localities);
        }
        
        return $localities;
    }
    
    public static function getAsSuggestions() {
        $list = Cache::read('localities_suggestion');
        if (!$list) {
            $localitiesModel = new Locality();
            $localities = $localitiesModel->find('all');
            $list = array();
            foreach ($localities as $l) {
                $list[] = $l['Locality'];
            }
            $thesaurusModel = new LocalityThesaurus();
            $thes = $thesaurusModel->find('all', array('conditions'=>array('use_as_hint'=>true)));
            foreach ($thes as $t) {
                $list[] = array('id'=>$t['LocalityThesaurus']['id'], 'name'=>$t['LocalityThesaurus']['fake_name']);
            }
            Cache::write('localities_suggestion', $list);
        }        
        return $list;
    }
}

?>