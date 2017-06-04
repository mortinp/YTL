<?php

class EmailsUtil {
    
    public static function email($to, $subject, array $vars, $config, $template, $options = null, $format = 'html') {
        $OK = true;
        if( (Configure::read('enqueue_mail') && !isset($options['enqueue'])) || (isset($options['enqueue']) && $options['enqueue']) ) {
            $defaultOpt = array(
                        'template'=>$template,
                        'format'=>$format,
                        'subject'=>$subject,
                        'config'=>$config);
            if($options != null) $options = array_merge($defaultOpt, $options); else $options = $defaultOpt;
            
            ClassRegistry::init('EmailQueue.EmailQueue')->enqueue(
                    $to,
                    $vars,
                    $options);
        } else {
            // Send email and redirect to a welcome page
            $Email = new CakeEmail($config);
            $Email->template($template)
            ->viewVars($vars)
            ->emailFormat($format)
            ->to($to)
            ->subject($subject);
            try {
                $Email->send();
            } catch ( Exception $e ) {
                $OK = false;
            }
        }
        
        return $OK;
    }
}
?>
