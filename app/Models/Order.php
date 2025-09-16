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
        'customer_name',
        'customer_email',
        'customer_phone',
        'payment_method_id',
        'extra_note',
        'status',
        'delivery_date',
        'payment_date',
        'payment_status',
        'street_address',
        'shipping_address',
        'city_id',
        'country_id',
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
        'shipping_address' => 'array',
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

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function shipment()
    {
        return $this->hasOne(Shipment::class);
    }

    /**
     * Get the total amount in decimal format
     */
    public function getTotalAmountAttribute()
    {
        return $this->total; // Return as rupees without conversion
    }
}
