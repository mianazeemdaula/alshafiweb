<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    protected $table = 'couriers';
    protected $fillable = [
        'courier', // trax, tcs, leopards
        'api_key',
        'api_password',
        'client_id',
        'client_secret',
        'token',
        'token_expiry',
        'extra', // JSON for any extra fields
    ];
}
