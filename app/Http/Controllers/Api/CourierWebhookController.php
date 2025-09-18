<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CourierWebhookController extends Controller
{
    /**
     * Handle Trax webhook for shipment status updates
     */
    public function traxWebhook(Request $request)
    {
        try {
            Log::info('Trax Webhook Received:', $request->all());

            // Validate required fields based on Trax webhook documentation and real payloads
            // Trax sometimes sends `date_time`, `order_id`, `courier_name`, `otp` etc. so accept those as well.
            $validator = Validator::make($request->all(), [
                'tracking_number' => 'required|string',
                'status' => 'required|string',
                'date_time' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                Log::error('Trax Webhook Validation Failed:', $validator->errors()->toArray());
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid webhook data',
                    'errors' => $validator->errors()
                ], 400);
            }

            $trackingNumber = $request->tracking_number;
            $status = $request->status;

            // Find shipment by tracking number
            $shipment = Shipment::where('tracking_number', $trackingNumber)
                ->orWhereJsonContains('courier_response->raw_response->tracking_number', $trackingNumber)
                ->first();

            if (!$shipment) {
                Log::warning("Trax Webhook: Shipment not found for tracking number: {$trackingNumber}");
                return response()->json([
                    'success' => false,
                    'message' => 'Shipment not found'
                ], 404);
            }

            // Map Trax status to our system status
            $mappedStatus = $this->mapTraxStatus($status);
            // Update shipment status
            $updateData = [
                'status' => $mappedStatus
            ];

            // Set appropriate timestamps based on status
            switch ($mappedStatus) {
                case 'in_transit':
                    $updateData['shipped_at'] = now();
                    break;
                case 'delivered':
                    $updateData['delivered_at'] = now();
                    break;
                case 'cancelled':
                case 'returned':
                    $updateData['cancelled_at'] = now();
                    break;
            }

            $shipment->update($updateData);

            // Update order status
            $this->updateOrderStatus($shipment, $mappedStatus);

            Log::info("Trax Webhook: Updated shipment {$shipment->id} status to {$mappedStatus}");

            return response()->json([
                'success' => true,
                'message' => 'Webhook processed successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Trax Webhook Error:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Internal server error'
            ], 500);
        }
    }

    /**
     * Handle TCS webhook for shipment status updates
     */
    public function tcsWebhook(Request $request)
    {
        try {
            Log::info('TCS Webhook Received:', $request->all());

            // Validate required fields based on TCS webhook documentation
            $validator = Validator::make($request->all(), [
                'consignmentNumber' => 'required|string',
                'status' => 'required|string',
                'statusDate' => 'nullable|string',
                'statusTime' => 'nullable|string',
                'location' => 'nullable|string',
                'remarks' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                Log::error('TCS Webhook Validation Failed:', $validator->errors()->toArray());
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid webhook data',
                    'errors' => $validator->errors()
                ], 400);
            }

            $consignmentNumber = $request->consignmentNumber;
            $status = $request->status;

            // Find shipment by tracking number
            $shipment = Shipment::where('tracking_number', $consignmentNumber)
                ->orWhere('courier_shipment_id', $consignmentNumber)
                ->first();

            if (!$shipment) {
                Log::warning("TCS Webhook: Shipment not found for consignment number: {$consignmentNumber}");
                return response()->json([
                    'success' => false,
                    'message' => 'Shipment not found'
                ], 404);
            }

            // Map TCS status to our system status
            $mappedStatus = $this->mapTcsStatus($status);
            
            // Update shipment status
            $updateData = [
                'status' => $mappedStatus
            ];

            // Set appropriate timestamps based on status
            switch ($mappedStatus) {
                case 'in_transit':
                    $updateData['shipped_at'] = now();
                    break;
                case 'delivered':
                    $updateData['delivered_at'] = now();
                    break;
                case 'cancelled':
                case 'returned':
                    $updateData['cancelled_at'] = now();
                    break;
            }

            $shipment->update($updateData);

            // Update order status
            $this->updateOrderStatus($shipment, $mappedStatus);

            Log::info("TCS Webhook: Updated shipment {$shipment->id} status to {$mappedStatus}");

            return response()->json([
                'success' => true,
                'message' => 'Webhook processed successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('TCS Webhook Error:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Internal server error'
            ], 500);
        }
    }

    /**
     * Handle Leopards webhook for shipment status updates
     */
    public function leopardsWebhook(Request $request)
    {
        try {
            Log::info('Leopards Webhook Received:', $request->all());

            // Validate required fields based on Leopards webhook documentation
            $validator = Validator::make($request->all(), [
                'tracking_number' => 'required|string',
                'status' => 'required|string',
                'status_date' => 'nullable|string',
                'status_time' => 'nullable|string',
                'location' => 'nullable|string',
                'remarks' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                Log::error('Leopards Webhook Validation Failed:', $validator->errors()->toArray());
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid webhook data',
                    'errors' => $validator->errors()
                ], 400);
            }

            $trackingNumber = $request->tracking_number;
            $status = $request->status;

            // Find shipment by tracking number
            $shipment = Shipment::where('tracking_number', $trackingNumber)
                ->orWhere('courier_shipment_id', $trackingNumber)
                ->first();

            if (!$shipment) {
                Log::warning("Leopards Webhook: Shipment not found for tracking number: {$trackingNumber}");
                return response()->json([
                    'success' => false,
                    'message' => 'Shipment not found'
                ], 404);
            }

            // Map Leopards status to our system status
            $mappedStatus = $this->mapLeopardsStatus($status);
            
            // Update shipment status
            $updateData = [
                'status' => $mappedStatus
            ];

            // Set appropriate timestamps based on status
            switch ($mappedStatus) {
                case 'in_transit':
                    $updateData['shipped_at'] = now();
                    break;
                case 'delivered':
                    $updateData['delivered_at'] = now();
                    break;
                case 'cancelled':
                case 'returned':
                    $updateData['cancelled_at'] = now();
                    break;
            }

            $shipment->update($updateData);

            // Update order status
            $this->updateOrderStatus($shipment, $mappedStatus);

            Log::info("Leopards Webhook: Updated shipment {$shipment->id} status to {$mappedStatus}");

            return response()->json([
                'success' => true,
                'message' => 'Webhook processed successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Leopards Webhook Error:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Internal server error'
            ], 500);
        }
    }

    /**
     * Map Trax status to system status
     */
    private function mapTraxStatus($traxStatus)
    {
        $statusMap = [
            'Shipment - Booked' => 'booked',
            'Shipment - Dispatched' => 'in_transit',
            'In Transit' => 'in_transit',
            'Shipment - Out for Delivery' => 'out_for_delivery',
            'Shipment - Arrived at Destination' => 'out_for_delivery',
            'Out for Delivery' => 'out_for_delivery',
            'Shipment - Delivered' => 'delivered',
            'Delivered' => 'delivered',
            'Returned' => 'returned',
            'Return - Confirm' => 'returned',
            'Cancelled' => 'cancelled',
            'On Hold' => 'on_hold',
            'Exception' => 'exception'
        ];

        return $statusMap[$traxStatus] ?? 'unknown';
    }

    /**
     * Map TCS status to system status
     */
    private function mapTcsStatus($tcsStatus)
    {
        $statusMap = [
            'Booked' => 'booked',
            'Picked Up' => 'picked_up',
            'In Transit' => 'in_transit',
            'Out for Delivery' => 'out_for_delivery',
            'Delivered' => 'delivered',
            'Returned' => 'returned',
            'Cancelled' => 'cancelled',
            'On Hold' => 'on_hold',
            'Exception' => 'exception'
        ];

        return $statusMap[$tcsStatus] ?? 'unknown';
    }

    /**
     * Map Leopards status to system status
     */
    private function mapLeopardsStatus($leopardsStatus)
    {
        $statusMap = [
            'Booked' => 'booked',
            'Picked' => 'picked_up',
            'In Transit' => 'in_transit',
            'Out for Delivery' => 'out_for_delivery',
            'Delivered' => 'delivered',
            'Returned' => 'returned',
            'Cancelled' => 'cancelled',
            'On Hold' => 'on_hold',
            'Exception' => 'exception'
        ];

        return $leopardsStatus ? $statusMap[$leopardsStatus] ?? 'unknown' : 'unknown';
    }

    /**
     * Update order status based on shipment status
     */
    private function updateOrderStatus($shipment, $shipmentStatus)
    {
        $order = $shipment->order;
        
        if (!$order) {
            return;
        }

        $orderStatusMap = [
            'booked' => 'processing',
            'picked_up' => 'shipped',
            'in_transit' => 'shipped',
            'out_for_delivery' => 'shipped',
            'delivered' => 'delivered',
            'returned' => 'returned',
            'cancelled' => 'cancelled'
        ];

        $newOrderStatus = $orderStatusMap[$shipmentStatus] ?? null;

        if ($newOrderStatus && $order->status !== $newOrderStatus) {
            $order->update(['status' => $newOrderStatus]);
            Log::info("Updated order {$order->id} status to {$newOrderStatus}");
        }
    }

    /**
     * Generic webhook for testing purposes
     */
    public function testWebhook(Request $request)
    {
        Log::info('Test Webhook Received:', $request->all());
        
        return response()->json([
            'success' => true,
            'message' => 'Test webhook received successfully',
            'data' => $request->all()
        ]);
    }
}