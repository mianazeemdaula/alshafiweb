<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Bonus;

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
     */
    public function updated(Order $order): void
    {
        // Check if status was changed to 'delivered' and it's a manual order
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
