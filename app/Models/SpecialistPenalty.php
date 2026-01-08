<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialistPenalty extends Model
{
    use HasFactory;

    protected $fillable = [
        'specialist_id',
        'order_id',
        'penalty_amount',
        'reason',
        'status',
        'notes',
        'applied_at',
    ];

    protected $casts = [
        'applied_at' => 'datetime',
        'penalty_amount' => 'integer',
    ];

    /**
     * Get the specialist who received this penalty
     */
    public function specialist()
    {
        return $this->belongsTo(User::class, 'specialist_id');
    }

    /**
     * Get the order that triggered this penalty
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Apply the penalty
     */
    public function apply()
    {
        $this->status = 'applied';
        $this->applied_at = now();
        $this->save();
    }

    /**
     * Reverse the penalty
     */
    public function reverse($notes = null)
    {
        $this->status = 'reversed';
        if ($notes) {
            $this->notes = $notes;
        }
        $this->save();
    }

    /**
     * Default penalty amount constant
     */
    const DEFAULT_PENALTY_AMOUNT = 200;
}
