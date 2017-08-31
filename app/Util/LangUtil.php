<?php
    class LangUtil {
        
        public static function getLangSetup($lang) {
            $langs = array(
                'es'=>array('desc'=>__('Español'), 'alt'=>'en', 'altDesc'=>__('Inglés')),
                'en'=>array('desc'=>__('Inglés'), 'alt'=>'es', 'altDesc'=>__('Español')),
            );
            
            return $langs[$lang];
        }
    }
?>
