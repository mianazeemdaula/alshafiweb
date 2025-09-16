<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourierServiceConfig extends Model
{
    use HasFactory;

    protected $table = 'courier_service_configs';

    protected $fillable = [
        'courier',
        'api_key',
        'api_password',
        'client_id',
        'client_secret',
        'token',
        'token_expiry',
        'extra',
        'is_active'
    ];

    protected $casts = [
        'extra' => 'array',
        'is_active' => 'boolean'
    ];

    /**
     * Get the API URL based on mode (sandbox/production)
     */
    public function getApiUrl($endpoint = '')
    {
        $mode = $this->extra['mode'] ?? 'production';
        $urls = config("couriers.{$this->courier}.{$mode}_urls", []);
        
        return $urls[$endpoint] ?? '';
    }

    /**
     * Check if courier is in sandbox mode
     */
    public function isSandbox()
    {
        return ($this->extra['mode'] ?? 'production') === 'sandbox';
    }

    /**
     * Get formatted courier name
     */
    public function getFormattedNameAttribute()
    {
        return ucfirst($this->courier);
    }
}
