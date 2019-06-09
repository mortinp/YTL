<?php
App::uses('AppModel', 'Model');
class Province extends AppModel {
    public $order = 'id';
    
    public $hasMany = array(
        'Locality' => array(
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
    
    
    public static $provinces = array(
        1=>array('name'=>'Granma', 'slug'=>'granma', 'featured_activity'=>'Visita a la Sierra Maestra'),
        2=>array('name'=>'Santiago de Cuba', 'slug'=>'santiago-de-cuba', 'featured_activity'=>'Traslado a Baracoa'),
        4=>array('name'=>'Holguín', 'slug'=>'holguin', 'featured_activity'=>'Traslado a Guardalavaca'),
        5=>array('name'=>'La Habana', 'slug'=>'la-habana', 'featured_activity'=>'Tour de un día a Viñales'),
        6=>array('name'=>'Varadero, Matanzas', 'slug'=>'varadero-matanzas', 'featured_activity'=>'Visita de un día a La Habana'),
        7=>array('name'=>'Villa Clara', 'slug'=>'santa-clara-villa-clara', 'featured_activity'=>'Traslados en Santa Clara'),
        8=>array('name'=>'Viñales, Pinar del Río', 'slug'=>'vinales-pinar-del-rio', 'featured_activity'=>'Traslado a La Habana'),
        9=>array('name'=>'Camaguey', 'slug'=>'camaguey', 'featured_activity'=>'Traslado a Trinidad'),
        10=>array('name'=>'Trinidad, Sancti Spíritus', 'slug'=>'trinidad-sancti-spiritus', 'featured_activity'=>'Visita a El Nicho'),
        11=>array('name'=>'Cienfuegos', 'slug'=>'cienfuegos', 'featured_activity'=>'Traslado a Trinidad'),
        12=>array('name'=>'Ciego de Ávila', 'slug'=>'ciego-de-avila', 'featured_activity'=>'Recogida en Cayo Coco/Guillermo')
    );
    public static function _provinceFromSlug($slug) {
        // Sanity checks
        if($slug == null) return null;
        
        // Convertir slug a id
        $pId = null;
        foreach (self::$provinces as $k=>$p) {
            if($p['slug'] == $slug) {
                $pId = $k;
                break;
            }
        }
        
        return $pId;
    }
    public static function getFeaturedActivityFromProvince($provinceId) {
        return __d('seo', self::$provinces[$provinceId]['featured_activity']);
    }
}

?>