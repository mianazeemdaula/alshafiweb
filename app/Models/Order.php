<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'discount',
        'vat',
        'shipping_cost',
        'status',
        'payment_status',
        'payment_method',
        'shipping_address',
        'billing_address',
        'shipping_method',
        'shipping_date',
        'delivery_date',
        'payment_date',
        'payment_ref',
        'payment_info',
        'payment_status',
        'payment_method',
        'payment_date',
        'payment_ref',
        'payment_info',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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
