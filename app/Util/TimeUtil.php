<?php

class TimeUtil {
    
    public static $months_es = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
    public static $days_es = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
    
    public static function prettyDate($date, $dayOfWeek = true) {
        
        $date_converted = strtotime($date);
        $day = date('j', $date_converted);
        $month = __(TimeUtil::$months_es[date('n', $date_converted) - 1]);
        $year = date('Y', $date_converted);
        
        $pretty_date = $day.' '.$month.', '.$year;
        
        if($dayOfWeek) {
            $day_of_week = __(TimeUtil::$days_es[date('w', $date_converted)]);
            $pretty_date .= ' ('.$day_of_week.')';
        }
        
        return $pretty_date;
    }
    
    public static function prettyDateShort($date, $dayOfWeek = true) {
        
        $date_converted = strtotime($date);
        $day = date('j', $date_converted);
        $month = __(TimeUtil::$months_es[date('n', $date_converted) - 1]);
        $year = date('Y', $date_converted);
        
        $pretty_date = $day.' '.$month;
        
        if($dayOfWeek) {
            $day_of_week = __(TimeUtil::$days_es[date('w', $date_converted)]);
            $pretty_date .= ' ('.$day_of_week.')';
        }
        
        return $pretty_date;
    }
    
    public static function wasBefore($timeInterval, $dateString, $timezone = null) {
        $tmp = str_replace(' ', '', $timeInterval);
        if (is_numeric($tmp)) {
            $timeInterval = $tmp . ' ' . __d('cake', 'days');
        }

        $date = CakeTime::fromString($dateString, $timezone);
        $interval = CakeTime::fromString('-' . $timeInterval);
        $now = CakeTime::fromString('now', $timezone);

        return $date <= $interval;
    }
    
    public static function dmY_to_Ymd($date){
        $sep = substr($date, 2, 1);
        $d = substr($date, 0, 2);
        $m = substr($date, 3, 2);
        $Y = substr($date, 6);
        
        return $Y.$sep.$m.$sep.$d;
    }
    
    public static function dateFormatAfterFind($date) {
        return date('d-m-Y', strtotime($date));
    }
    
    public static function dateFormatBeforeSave($date) {
        $d = str_replace('-', '/', $date);
        $d = explode('/', $d);
        $newD = $d['2'].'-'.$d[1].'-'.$d[0];
        
        return $newD;
    }
    
    public static function daysFrom($str_date) {
        $now = new DateTime(date('Y-m-d', time()));
        return $now->diff(new DateTime($str_date), true)->format('%a');
    }
    
}
?>