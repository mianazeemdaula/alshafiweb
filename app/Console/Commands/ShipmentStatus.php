<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\UnifiedCourierService;

class ShipmentStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'courier:shipment-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and update shipment statuses from courier services';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $shipments = \App\Models\Shipment::whereIn('status', [
            \App\Models\Shipment::STATUS_BOOKED,
            \App\Models\Shipment::STATUS_PICKED_UP,
            \App\Models\Shipment::STATUS_IN_TRANSIT,
            \App\Models\Shipment::STATUS_OUT_FOR_DELIVERY
        ])->whereNot('courier_service_config_id',1)->get();

        foreach ($shipments as $shipment) {
            $courier = $shipment->courierService;
            if (!$courier || !$courier->is_active) {
                $this->error("Courier service not found or inactive for shipment ID: {$shipment->id}");
                continue;
            }

            $courierService = new UnifiedCourierService();
            try {
                $trackingNumber = $shipment->tracking_number ?? $shipment->courier_response['tracking_number'] ?? null;
                if (!$trackingNumber) {
                    $this->error("No tracking number found for shipment ID: {$shipment->id}");
                    continue;
                }
                $response = $courierService->trackShipment($courier->courier, $trackingNumber);
                if($response && $response['success']){
                    $status = $response['current_status'] ?? null;
                    if($status && $status !== $shipment->status){
                        $shipment->status = $status;
                        if($status === \App\Models\Shipment::STATUS_DELIVERED){
                            $shipment->delivered_at = now();
                        } elseif($status === \App\Models\Shipment::STATUS_CANCELLED){
                            $shipment->cancelled_at = now();
                        }else if($status === \App\Models\Shipment::STATUS_PICKED_UP){
                            $shipment->shipped_at = now();
                        }else if($status === \App\Models\Shipment::STATUS_RETURNED){
                            $shipment->cancelled_at = now();
                        }else if($status === \App\Models\Shipment::STATUS_IN_TRANSIT){
                            $shipment->shipped_at = $shipment->shipped_at ?? now();
                        }
                        $shipment->save();
                        $this->info("Updated shipment ID: {$shipment->id} to status: {$status}");
                    } else {
                        $this->info("No status change for shipment ID: {$shipment->id}");
                        
                    }
                } else {
                    $this->error("Failed to fetch status for shipment ID: {$shipment->id}");
                    continue;
                }
            } catch (\Exception $e) {
                $this->error("Error fetching status for shipment ID: {$shipment->id}. Error: {$e->getMessage()}");
            }
        }
    }
}
