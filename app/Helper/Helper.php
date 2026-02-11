<?php

namespace App\Helper;

use App\Models\SiteSetting;

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
    
    /**
     * Get a site setting value by key
     * 
     * @param string $key The setting key
     * @param mixed $default Default value if setting not found
     * @return mixed
     */
    public static function setting($key, $default = null)
    {
        return SiteSetting::get($key, $default);
    }
}