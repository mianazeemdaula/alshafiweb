<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'courier_service_config_id',
        'tracking_number',
        'courier_shipment_id',
        'status',
        'pickup_address',
        'delivery_address',
        'weight',
        'dimensions',
        'declared_value',
        'cod_amount',
        'special_instructions',
        'courier_response',
        'shipped_at',
        'delivered_at',
        'cancelled_at',
        'cancellation_reason'
    ];

    protected $casts = [
        'pickup_address' => 'array',
        'delivery_address' => 'array',
        'dimensions' => 'array',
        'courier_response' => 'array',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'declared_value' => 'decimal:2',
        'cod_amount' => 'decimal:2',
        'weight' => 'decimal:3'
    ];

    // Relationship with Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relationship with CourierServiceConfig
    public function courierService()
    {
        return $this->belongsTo(CourierServiceConfig::class, 'courier_service_config_id');
    }

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_BOOKED = 'booked';
    const STATUS_PICKED_UP = 'picked_up';
    const STATUS_IN_TRANSIT = 'in_transit';
    const STATUS_OUT_FOR_DELIVERY = 'out_for_delivery';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_RETURNED = 'returned';

    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_BOOKED => 'Booked',
            self::STATUS_PICKED_UP => 'Picked Up',
            self::STATUS_IN_TRANSIT => 'In Transit',
            self::STATUS_OUT_FOR_DELIVERY => 'Out for Delivery',
            self::STATUS_DELIVERED => 'Delivered',
            self::STATUS_CANCELLED => 'Cancelled',
            self::STATUS_RETURNED => 'Returned'
        ];
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            self::STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
            self::STATUS_BOOKED => 'bg-blue-100 text-blue-800',
            self::STATUS_PICKED_UP => 'bg-indigo-100 text-indigo-800',
            self::STATUS_IN_TRANSIT => 'bg-purple-100 text-purple-800',
            self::STATUS_OUT_FOR_DELIVERY => 'bg-orange-100 text-orange-800',
            self::STATUS_DELIVERED => 'bg-green-100 text-green-800',
            self::STATUS_CANCELLED => 'bg-red-100 text-red-800',
            self::STATUS_RETURNED => 'bg-gray-100 text-gray-800'
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getCourierNameAttribute()
    {
        return $this->courierService ? ucfirst($this->courierService->courier) : 'N/A';
    }
}
