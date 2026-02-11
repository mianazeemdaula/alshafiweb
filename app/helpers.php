<?php

use App\Models\SiteSetting;

if (!function_exists('setting')) {
    /**
     * Get a site setting value by key
     * 
     * @param string $key The setting key
     * @param mixed $default Default value if setting not found
     * @return mixed
     */
    function setting($key, $default = null)
    {
        return SiteSetting::get($key, $default);
    }
}
