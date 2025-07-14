<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles, HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'fcm_token',
        'ref_code',
        'level_id',
        'referrer',
        'extra_discount',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // orders

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    public function productReviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function referrProducts()
    {
        return $this->hasMany(ReferrProduct::class);
    }
    
    public function userLevel()
    {
        return $this->belongsTo(UserLevel::class, 'level_id');
    }
    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->ref_code)) {
                do {
                    $code = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
                } while (self::where('ref_code', $code)->exists());
                $user->ref_code = $code;
            }
        });
    }

    public function getTotalShoppingAttribute()
    {
        return $this->orders()->sum('total');
    }

    public function getLevelByShopping()
    {
        $shopping = $this->total_shopping;
        return UserLevel::where('min_points', '<=', $shopping)
            ->orderByDesc('min_points')
            ->first();
    }
    
    public function getLevelBenefitsAttribute()
    {
        $level = $this->getLevelByShopping();
        if (!$level) return null;
        return [
            'discount' => $level->discount,
            'cashback' => $level->cashback,
        ];
    }
}
