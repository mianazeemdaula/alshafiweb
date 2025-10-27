<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_taker_id',
        'order_id',
        'order_amount',
        'bonus_amount',
        'status',
        'paid_at',
        'notes',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'order_amount' => 'integer',
        'bonus_amount' => 'integer',
    ];

    /**
     * Get the order taker who earned this bonus
     */
    public function orderTaker()
    {
        return $this->belongsTo(User::class, 'order_taker_id');
    }

    /**
     * Get the order that generated this bonus
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Calculate 5% bonus from order total
     */
    public static function calculateBonusAmount($orderTotal)
    {
        return (int) ($orderTotal * 0.05);
    }
}
