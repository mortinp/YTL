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
        1=>array('name'=>'Granma', 'slug'=>'granma', 'featured_activity'=>'Visita a la Sierra Maestra', 'airport'=>'Manzanillo'),
        2=>array('name'=>'Santiago de Cuba', 'slug'=>'santiago-de-cuba', 'featured_activity'=>'Traslado a Baracoa', 'airport'=>'Santiago de Cuba'),
        4=>array('name'=>'Holguín', 'slug'=>'holguin', 'featured_activity'=>'Traslado a Guardalavaca', 'airport'=>'Holguín'),
        5=>array('name'=>'La Habana', 'slug'=>'la-habana', 'featured_activity'=>'Tour de un día a Viñales', 'airport'=>'La Habana'),
        6=>array('name'=>'Varadero, Matanzas', 'slug'=>'varadero-matanzas', 'featured_activity'=>'Visita de un día a La Habana', 'airport'=>'Varadero', 'alternative_province'=>5),
        7=>array('name'=>'Villa Clara', 'slug'=>'santa-clara-villa-clara', 'featured_activity'=>'Traslados en Santa Clara', 'airport'=>'Santa Clara'),
        8=>array('name'=>'Viñales, Pinar del Río', 'slug'=>'vinales-pinar-del-rio', 'featured_activity'=>'Traslado a La Habana', 'airport'=>false),
        9=>array('name'=>'Camaguey', 'slug'=>'camaguey', 'featured_activity'=>'Traslado a Trinidad', 'airport'=>'Camaguey'),
        10=>array('name'=>'Trinidad, Sancti Spíritus', 'slug'=>'trinidad-sancti-spiritus', 'featured_activity'=>'Visita a El Nicho', 'airport'=>false, 'alternative_province'=>11),
        11=>array('name'=>'Cienfuegos', 'slug'=>'cienfuegos', 'featured_activity'=>'Traslado a Trinidad', 'airport'=>false, 'alternative_province'=>10),
        12=>array('name'=>'Ciego de Ávila', 'slug'=>'ciego-de-avila', 'featured_activity'=>'Recogida en Cayo Coco/Guillermo', 'airport'=>'Cayo Coco/Guillermo')
    );
    public static function _provinceFromSlug($slug) {
        // Sanity checks
        if($slug == null) return null;
        
        // Convertir slug a id
        $province = null;
        foreach (self::$provinces as $k=>$p) {
            if($p['slug'] == $slug) {
                $province = $p;
                $province['id'] = $k;
                break;
            }
        }
        
        return $province;
    }
    public static function _servicesDescription($provinceId) {
        $province = self::$provinces[$provinceId];
        
        $desc = __d('mobirise/drivers_by_province', 'Taxi a tiempo completo').' - ';
        if($province['airport']) $desc .= __d('mobirise/drivers_by_province', 'Recogida en aeropuerto de %s', __($province['airport'])).' - ';
        $desc .= __d('mobirise/drivers_by_province', __d('mobirise/drivers_by_province', $province['featured_activity'])).' - ';
        $desc .= __d('mobirise/drivers_by_province', 'Tour por toda Cuba').' - ';
        $desc .= __d('mobirise/drivers_by_province', 'Traslados desde %s a cualquier destino', __($province['name']));
        
        return $desc;
    }
}

?>