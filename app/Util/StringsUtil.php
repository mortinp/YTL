<?php
    class StringsUtil {
        public function getWeirdString() {
            return substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1).substr(md5(time()),1);
        }
    }
?>
