<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
    ];

    /**
     * Get a setting value by key
     * Uses cache for better performance
     */
    public static function get($key, $default = null)
    {
        $cacheKey = 'site_setting_' . $key;
        
        return Cache::remember($cacheKey, 3600, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set a setting value by key
     */
    public static function set($key, $value)
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        // Clear cache
        Cache::forget('site_setting_' . $key);
        Cache::forget('all_site_settings');

        return $setting;
    }

    /**
     * Get all settings grouped by group
     */
    public static function getAllGrouped()
    {
        return Cache::remember('all_site_settings', 3600, function () {
            return self::all()->groupBy('group');
        });
    }

    /**
     * Get all settings for a specific group
     */
    public static function getGroup($group)
    {
        return Cache::remember('site_settings_group_' . $group, 3600, function () use ($group) {
            return self::where('group', $group)->get();
        });
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache()
    {
        $settings = self::all();
        foreach ($settings as $setting) {
            Cache::forget('site_setting_' . $setting->key);
        }
        Cache::forget('all_site_settings');
        
        // Clear group caches
        $groups = self::distinct('group')->pluck('group');
        foreach ($groups as $group) {
            Cache::forget('site_settings_group_' . $group);
        }
    }

    /**
     * Boot method to clear cache on model events
     */
    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            self::clearCache();
        });

        static::deleted(function () {
            self::clearCache();
        });
    }
}
