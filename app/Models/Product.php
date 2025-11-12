<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'country_id',
        'name',
        'sku',
        'weight',
        'price',
        'discount',
        'vat',
        'stock',
        'sales_count',
        'featured',
        'description',
        'extra_info',
        'referrer_discount',
        'referal_discount',
        'buyer_discount',
        'earn_points',
    ];

    public function getCurrencyAttribute()
    {
        return $this->country ? $this->country->currency_symbol : '$';
    }

    public function getFormattedPriceAttribute()
    {
        return $this->currency . ' ' . number_format($this->price, 2);
    }

    public function getFormattedOriginalPriceAttribute()
    {
        if (isset($this->discount) && $this->discount > 0) {
            $originalPrice = $this->price + $this->discount;
            return $this->currency . ' ' . number_format($originalPrice, 2);
        }
        return null;
    }

    public function getRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getAverageRatingAttribute()
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }

    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function offers()
    {
        return $this->hasMany(ProductOffer::class);
    }

    public function activeOffers()
    {
        return $this->hasMany(ProductOffer::class)->active();
    }

    /**
     * Get the best offer for a given quantity
     * Selects the offer that provides the maximum discount amount
     */
    public function getBestOffer($quantity)
    {
        $applicableOffers = $this->activeOffers()
            ->where('min_quantity', '<=', $quantity)
            ->get();
        
        if ($applicableOffers->isEmpty()) {
            return null;
        }
        
        // If only one offer, return it
        if ($applicableOffers->count() === 1) {
            return $applicableOffers->first();
        }
        
        // Compare discounts and return the one with maximum savings
        $bestOffer = null;
        $maxDiscount = 0;
        
        foreach ($applicableOffers as $offer) {
            $discount = $offer->calculateDiscount($quantity, $this->price);
            if ($discount > $maxDiscount) {
                $maxDiscount = $discount;
                $bestOffer = $offer;
            }
        }
        
        return $bestOffer;
    }

    /**
     * Calculate price with offer discount
     */
    public function getPriceWithOffer($quantity)
    {
        $offer = $this->getBestOffer($quantity);
        
        if (!$offer) {
            return $this->price * $quantity;
        }

        return $offer->getFinalPrice($quantity, $this->price);
    }

    public function referrProducts()
    {
        return $this->hasMany(ReferrProduct::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable')->orderBy('sort');
    }
}
