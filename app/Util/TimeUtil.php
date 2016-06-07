<?php

class TimeUtil {
    
    public static $months_es = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
    public static $days_es = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
    
    public static function prettyDate($date) {
        
        $date_converted = strtotime($date);
        $day = date('j', $date_converted);
        $month = __(TimeUtil::$months_es[date('n', $date_converted) - 1]);
        $day_of_week = __(TimeUtil::$days_es[date('w', $date_converted)]);
        $year = date('Y', $date_converted);
        $pretty_date = $day.' '.$month.', '.$year.' ('.$day_of_week.')';
        
        return $pretty_date;
    }
}
?>
