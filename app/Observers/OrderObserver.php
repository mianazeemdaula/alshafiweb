<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Bonus;
use App\Models\SpecialistPenalty;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "updated" event.
     * Check if order status changed to delivered and create bonus for manual orders
     * OR check if order status changed to returned/cancelled and create penalty for specialist orders
     */
    public function updated(Order $order): void
    {
        // Handle Manual Order Bonuses
        if ($order->isDirty('status') && 
            $order->status === 'delivered' && 
            $order->isManualOrder() && 
            $order->order_taker_id) {
            
            // Check if bonus already exists for this order
            $existingBonus = Bonus::where('order_id', $order->id)->first();
            
            if (!$existingBonus) {
                // Calculate 5% bonus
                $bonusAmount = Bonus::calculateBonusAmount($order->total);
                
                // Create bonus record
                Bonus::create([
                    'order_taker_id' => $order->order_taker_id,
                    'order_id' => $order->id,
                    'order_amount' => $order->total,
                    'bonus_amount' => $bonusAmount,
                    'status' => 'pending',
                    'notes' => 'Auto-generated 5% bonus for delivered manual order #' . $order->number,
                ]);
            }
        }

        // Handle Specialist Order Penalties (Non-Delivery)
        if ($order->isDirty('status') && 
            $order->isSpecialistOrder() && 
            $order->order_taker_id) {
            
            // Check if order was returned or cancelled (non-delivery)
            if (in_array($order->status, ['returned', 'cancelled'])) {
                // Check if penalty already exists for this order
                $existingPenalty = SpecialistPenalty::where('order_id', $order->id)->first();
                
                if (!$existingPenalty) {
                    // Create penalty record
                    $penalty = SpecialistPenalty::create([
                        'specialist_id' => $order->order_taker_id,
                        'order_id' => $order->id,
                        'penalty_amount' => SpecialistPenalty::DEFAULT_PENALTY_AMOUNT,
                        'reason' => 'Non-Delivery',
                        'status' => 'applied',
                        'notes' => "Auto-generated 200 PKR penalty for {$order->status} specialist order #{$order->number}",
                    ]);
                    $penalty->apply();
                }
            } elseif ($order->status === 'delivered') {
                // If order was previously marked as returned/cancelled but now delivered, 
                // reverse any existing penalty
                $existingPenalty = SpecialistPenalty::where('order_id', $order->id)
                                                    ->where('status', 'applied')
                                                    ->first();
                if ($existingPenalty) {
                    $existingPenalty->reverse('Order was delivered - penalty reversed');
                }
            }
        }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
