<?php
    class StringsUtil {
        public static function getWeirdString() {
            return substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1).substr(md5(time()),1);
        }
    }
?>
