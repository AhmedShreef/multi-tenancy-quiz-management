<?php 
if (!function_exists('remove_spaces')) {
    function remove_spaces($string) {
        return str_replace(' ', '-', $string);
    }
}