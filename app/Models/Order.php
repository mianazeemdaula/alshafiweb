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
        'type',
        'order_source',
        'order_taker_id',
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
        'reference_number',
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
     * Get the order taker who created this manual order
     */
    public function orderTaker()
    {
        return $this->belongsTo(User::class, 'order_taker_id');
    }

    /**
     * Get the bonus associated with this order
     */
    public function bonus()
    {
        return $this->hasOne(Bonus::class);
    }

    /**
     * Scope to get only website orders
     */
    public function scopeWebsiteOrders($query)
    {
        return $query->where('order_source', 'website');
    }

    /**
     * Scope to get only manual orders
     */
    public function scopeManualOrders($query)
    {
        return $query->where('order_source', 'manual');
    }

    /**
     * Scope to get orders visible to a specific user based on their role
     */
    public function scopeVisibleTo($query, User $user)
    {
        if ($user->isAdmin()) {
            // Admin sees all orders
            return $query;
        } elseif ($user->isLabelPrinter()) {
            // Label printer: show manual orders created by their team members OR assigned to themselves
            return $query->where('order_source', 'manual')
                         ->where(function ($subQ) use ($user) {
                             $subQ->whereHas('orderTaker', function ($q) use ($user) {
                                 $q->where('team_leader_id', $user->id);
                             })
                             ->orWhere('order_taker_id', $user->id);
                         });
        } elseif ($user->isOrderTaker()) {
            // Order taker sees only their own manual orders
            return $query->where('order_source', 'manual')
                         ->where('order_taker_id', $user->id);
        }

        // Default: no orders visible
        return $query->where('id', null);
    }

    /**
     * Check if this is a manual order
     */
    public function isManualOrder()
    {
        return $this->order_source === 'manual';
    }

    /**
     * Check if this is a website order
     */
    public function isWebsiteOrder()
    {
        return $this->order_source === 'website';
    }

    /**
     * Get the total amount in decimal format
     */
    public function getTotalAmountAttribute()
    {
        return $this->total; // Return as rupees without conversion
    }

    // Order type constants
    const TYPE_CALL = 'call';
    const TYPE_CLINIC = 'clinic';
    const TYPE_WEBSITE = 'website';
    const TYPE_REPEAT = 'repeat';
    const TYPE_COMPLAIN = 'complain';
    const TYPE_GIFT = 'gift';

    public static function getTypes()
    {
        return [
            self::TYPE_CALL => 'Call',
            self::TYPE_CLINIC => 'Clinic',
            self::TYPE_WEBSITE => 'Website',
            self::TYPE_REPEAT => 'Repeat',
            self::TYPE_COMPLAIN => 'Complain',
            self::TYPE_GIFT => 'Gift'
        ];
    }

    public function getTypeLabelAttribute()
    {
        $types = self::getTypes();
        return $types[$this->type] ?? ucfirst($this->type ?? '');
    }
}
