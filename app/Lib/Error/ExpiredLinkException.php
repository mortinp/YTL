<?php

class ExpiredLinkException extends CakeException {
    
    /**
 * Constructor
 *
 * @param string $message If no message is given 'Expired Link' will be the message
 * @param integer $code Status code, defaults to 404
 */
    public function __construct($message = null, $code = 404) {
        if (empty($message)) {
            $message = __d('error', 'Enlace Expirado');
        }
        parent::__construct($message, $code);
    }
}
?>
