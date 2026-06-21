<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ProductOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'title',
        'min_quantity',
        'discount_type',
        'discount_value',
        'is_active',
        'start_date',
        'end_date',
        'description',
        'priority',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'discount_value' => 'decimal:2',
    ];

    /**
     * Get the product that owns the offer
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Check if offer is currently valid
     */
    public function isValid()
    {
        if (!$this->is_active) {
            return false;
        }

        $now = Carbon::now();

        if ($this->start_date && $now->lt($this->start_date)) {
            return false;
        }

        if ($this->end_date && $now->gt($this->end_date)) {
            return false;
        }

        return true;
    }

    /**
     * Calculate discount amount for given quantity and price
     */
    public function calculateDiscount($quantity, $unitPrice)
    {
        if ($quantity < $this->min_quantity) {
            return 0;
        }

        $totalPrice = $quantity * $unitPrice;

        if ($this->discount_type === 'percentage') {
            return ($totalPrice * $this->discount_value) / 100;
        }

        return $this->discount_value;
    }

    /**
     * Get the final price after discount
     */
    public function getFinalPrice($quantity, $unitPrice)
    {
        $totalPrice = $quantity * $unitPrice;
        $discount = $this->calculateDiscount($quantity, $unitPrice);
        return $totalPrice - $discount;
    }

    /**
     * Scope to get only active offers
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_date')
                    ->orWhere('start_date', '<=', Carbon::now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', Carbon::now());
            })
            ->orderBy('priority', 'desc');
    }
}
