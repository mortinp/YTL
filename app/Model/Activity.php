<?php
App::uses('AppModel', 'Model');
?>

<?php

class Activity extends AppModel {
    
    public static $activities = array(
        0=>array(
            'name'=>'Tour de 1 día a Viñales desde La Habana',
            'slug'=>'daytour-vinales-from-havana',
            'display_page'=>'daytour-hav-vin',
        ),
        
        1=>array(
            'name'=>'Tour de 1 día a Varadero desde La Habana',
            'slug'=>'daytour-varadero-from-havana',
            'display_page'=>'daytour-hav-var',
        ),
        
        2=>array(
            'name'=>'Enlace con Viazul en Santa Clara hacia Cayo Santa María',
            'slug'=>'taxi-santa-clara-cayo-santa-maria',
            'display_page'=>'taxi-scl-csm',
        )
    );
}

?>