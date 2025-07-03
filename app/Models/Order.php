<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'user_id',
        'payment_method_id',
        'extra_note',
        'status',
        'delivery_date',
        'payment_date',
        'payment_status',
        'street_address',
        'city_id',
        'zip_code',
        'shipping_cost',
        'discount',
        'total',
    ];

    protected $casts = [
        'delivery_date' => 'datetime',
        'payment_date' => 'datetime',
        'total' => 'integer',
        'discount' => 'integer',
        'shipping_cost' => 'integer',
        'zip_code' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
