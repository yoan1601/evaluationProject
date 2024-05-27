<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    if(!function_exists("object_array_to_associative_array")) {
        function object_array_to_associative_array($array_obj) {
            $array_assoc = [];
            foreach ($array_obj as $key => $obj) {
                $array_assoc [] = (array) $obj;
            }
            return $array_assoc;
        }
    }

    if(!function_exists("format_date_time")) {
        function format_date_time($date_time) {
            $dateObj = new DateTime($date_time);
            return $dateObj->format('d F Y - H\hi');
        }
    }

    if(!function_exists("format_date")){
        function format_date($date_input){
            $date = new DateTime($date_input);
            $dateFormatted = $date->format('l d F Y');
            return $dateFormatted;
        }
    }

    if(!function_exists("format_currency")){
        function format_currency($currency_input){
            $currency = number_format($currency_input, 2, '.', ' ');
            return $currency;
        }
    }
?>