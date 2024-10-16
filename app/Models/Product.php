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
        return $this->country->currency;
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

    public function referrProducts()
    {
        return $this->hasMany(ReferrProduct::class);
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable')->orderBy('sort');
    }
}
