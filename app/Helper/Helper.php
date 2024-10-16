<?php

namespace App\Helper;

class Helper
{
    public static function parseDigiPhone($value){
        // remove all spaces
        $value = str_replace(' ', '', $value);
        // remove + from the start
        $value = str_replace('+', '', $value);
        // remove - from the start
        return $value;
    }
}