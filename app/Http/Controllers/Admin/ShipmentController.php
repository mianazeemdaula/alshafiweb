<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\Order;
use App\Models\CourierServiceConfig;
use App\Services\UnifiedCourierService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShipmentController extends Controller
{
    protected $courierService;

    public function __construct(UnifiedCourierService $courierService)
    {
        $this->courierService = $courierService;
    }

    /**
     * Display a listing of shipments
     */
    public function index(Request $request)
    {
        $query = Shipment::with(['order', 'courierService']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by courier
        if ($request->filled('courier')) {
            $query->whereHas('courierService', function($q) use ($request) {
                $q->where('courier', $request->courier);
            });
        }

        // Search by tracking number or order ID
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('tracking_number', 'like', "%{$search}%")
                  ->orWhere('courier_shipment_id', 'like', "%{$search}%")
                  ->orWhereHas('order', function($orderQuery) use ($search) {
                      $orderQuery->where('id', 'like', "%{$search}%")
                               ->orWhere('order_number', 'like', "%{$search}%");
                  });
            });
        }

        $shipments = $query->latest()->paginate(20);
        $courierServices = CourierServiceConfig::where('is_active', true)->get();

        return view('admin.shipments.index', compact('shipments', 'courierServices'));
    }

    /**
     * Show the form for creating a new shipment
     */
    public function create(Request $request)
    {
        $order = null;
        if ($request->filled('order_id')) {
            $order = Order::with(['orderDetails.product', 'user'])->find($request->order_id);
            if (!$order) {
                return redirect()->route('admin.orders.index')
                    ->with('error', 'Order not found.');
            }
        }

        $courierServices = CourierServiceConfig::where('is_active', true)->get();
        $orders = Order::where('status', '!=', 'cancelled')
                       ->whereDoesntHave('shipment')
                       ->with('user')
                       ->latest()
                       ->take(50)
                       ->get();
            
        return view('admin.shipments.create', compact('order', 'courierServices', 'orders'));
    }

    /**
     * Store a newly created shipment
     */
    public function store(Request $request)
    {
        // Base validation rules
        $rules = [
            'order_id' => 'required|exists:orders,id',
            'courier_service_config_id' => 'required|exists:courier_service_configs,id',
            'weight' => 'required|numeric|min:0.1|max:999',
            'declared_value' => 'nullable|numeric|min:0',
            'cod_amount' => 'nullable|numeric|min:0',
            'special_instructions' => 'nullable|string|max:500',
            'delivery_name' => 'required|string|max:100',
            'delivery_phone' => 'required|string|max:20',
            'delivery_address' => 'required|string|max:255',
            'delivery_city_id' => 'required|string|max:100'
        ];

        // Add pickup validation based on pickup type
        if ($request->pickup_type === 'existing') {
            $rules['pickup_address_id'] = 'required|string';
        } else {
            $rules['pickup_name'] = 'required|string|max:100';
            $rules['pickup_phone'] = 'required|string|max:20';
            $rules['pickup_address'] = 'required|string|max:255';
            $rules['pickup_city'] = 'required|string|max:100';
        }

        $request->validate($rules);

        $order = Order::findOrFail($request->order_id);
        $courierConfig = CourierServiceConfig::findOrFail($request->courier_service_config_id);

        // Check if order already has a shipment
        if ($order->shipment) {
            return redirect()->back()
                ->with('error', 'This order already has a shipment.');
        }

        try {
            // Prepare pickup address data
            $pickupData = [];
            if ($request->pickup_type === 'existing') {
                $pickupData = [
                    'type' => 'existing',
                    'pickup_address_id' => $request->pickup_address_id
                ];
            } else {
                $pickupData = [
                    'type' => 'manual',
                    'name' => $request->pickup_name,
                    'phone' => $request->pickup_phone,
                    'address' => $request->pickup_address,
                    'city' => $request->pickup_city
                ];
            }

            // Prepare shipment data for courier booking
            $shipmentData = [
                'delivery_name' => $request->delivery_name,
                'delivery_phone' => $request->delivery_phone,
                'delivery_address' => $request->delivery_address,
                'delivery_city_id' => $request->delivery_city_id,
                'weight' => $request->weight, // Weight in kg (will be converted by service as needed)
                'pieces' => 1,
                'cod_amount' => $request->cod_amount ?? $order->total_amount,
                'declared_value' => $request->declared_value ?? $order->total_amount,
                'special_instructions' => $request->special_instructions ?? '',
                'order_id' => $request->reference ?? 'ORD-' . $order->id,
                'description' => $order->orderDetails->pluck('product.sku')->unique()->implode(', '),
                'manual_id' => $order->id // For manual shipments
            ];

            // Add pickup data based on type
            if ($request->pickup_type === 'existing') {
                $shipmentData['pickup_address_id'] = $request->pickup_address_id;
            } else {
                $shipmentData['pickup_name'] = $request->pickup_name;
                $shipmentData['pickup_phone'] = $request->pickup_phone;
                $shipmentData['pickup_email'] = 'info@alshaafi.com'; // Default email
                $shipmentData['pickup_address'] = $request->pickup_address;
                $shipmentData['pickup_city_id'] = $request->pickup_city; // For now use city name
            }
            $response = $this->courierService->bookShipment($courierConfig->courier, $shipmentData);
            
            Log::info('Shipment booking response: ' . json_encode($response));
            
            // Handle booking response - check for success or error status
            if (isset($response['success']) && $response['success']) {

                // Create shipment record
                $shipment = Shipment::create([
                    'order_id' => $order->id,
                    'courier_service_config_id' => $courierConfig->id,
                    'status' => Shipment::STATUS_PENDING,
                    'pickup_address' => $pickupData,
                    'delivery_address' => [
                        'name' => $request->delivery_name,
                        'phone' => $request->delivery_phone,
                        'address' => $request->delivery_address,
                        'city_id' => $request->delivery_city_id
                    ],
                    'weight' => $request->weight,
                    'declared_value' => $request->declared_value,
                    'cod_amount' => $request->cod_amount ?? $order->total_amount,
                    'special_instructions' => $request->special_instructions
                ]);
                // Update shipment with courier response
                $shipment->update([
                    'status' => Shipment::STATUS_BOOKED,
                    'tracking_number' => $response['tracking_number'] ?? $response['raw_response']['tracking_number'] ?? null,
                    'courier_shipment_id' => $response['shipment_id'] ?? null,
                    'courier_response' => $response,
                    'shipped_at' => now()
                ]);

                // Update order status
                $order->update(['status' => 'shipped']);
                return redirect()->route('admin.shipments.show', $shipment)
                    ->with('success', 'Shipment created and booked successfully!');
            } else {
                // Handle error response
                $errorMessage = $response['message'] ?? $response['error'] ?? 'Unknown error occurred';
                
                Log::error('Shipment booking failed: ' . $errorMessage, ['response' => $response]);
                
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Failed to create shipment: ' . $errorMessage);
            }

        } catch (\Exception $e) {
            Log::error('Shipment creation failed: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create shipment: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified shipment
     */
    public function show(Shipment $shipment)
    {
        $shipment->load(['order.orderDetails.product', 'order.user', 'courierService']);
        return view('admin.shipments.show', compact('shipment'));
    }

    /**
     * Show the form for editing the specified shipment
     */
    public function edit(Shipment $shipment)
    {
        $shipment->load(['order', 'courierService']);
        $courierServices = CourierServiceConfig::where('is_active', true)->get();
        
        return view('admin.shipments.edit', compact('shipment', 'courierServices'));
    }

    /**
     * Update the specified shipment
     */
    public function update(Request $request, Shipment $shipment)
    {
        $request->validate([
            'weight' => 'required|numeric|min:0.1|max:999',
            'declared_value' => 'nullable|numeric|min:0',
            'cod_amount' => 'nullable|numeric|min:0',
            'special_instructions' => 'nullable|string|max:500',
            'status' => 'required|in:' . implode(',', array_keys(Shipment::getStatuses()))
        ]);

        $originalStatus = $shipment->status;

        $shipment->update([
            'weight' => $request->weight,
            'declared_value' => $request->declared_value,
            'cod_amount' => $request->cod_amount,
            'special_instructions' => $request->special_instructions,
            'status' => $request->status
        ]);

        // Update timestamps based on status change
        if ($originalStatus !== $request->status) {
            switch ($request->status) {
                case Shipment::STATUS_DELIVERED:
                    $shipment->update(['delivered_at' => now()]);
                    $shipment->order->update(['status' => 'delivered']);
                    break;
                case Shipment::STATUS_CANCELLED:
                    $shipment->update(['cancelled_at' => now()]);
                    break;
            }
        }

        return redirect()->route('admin.shipments.show', $shipment)
            ->with('success', 'Shipment updated successfully!');
    }

    /**
     * Remove the specified shipment
     */
    public function destroy(Shipment $shipment)
    {
        if ($shipment->status === Shipment::STATUS_DELIVERED) {
            return redirect()->back()
                ->with('error', 'Cannot delete a delivered shipment.');
        }

        $order = $shipment->order;
        $shipment->delete();

        // Reset order status if it was shipped
        if ($order->status === 'shipped') {
            $order->update(['status' => 'processing']);
        }

        return redirect()->route('admin.shipments.index')
            ->with('success', 'Shipment deleted successfully!');
    }

    /**
     * Track shipment status
     */
    public function track(Shipment $shipment)
    {
        try {
            if (!$shipment->tracking_number && !$shipment->courier_shipment_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tracking information available'
                ]);
            }

            $trackingNumber = $shipment->tracking_number ?? $shipment->courier_response['raw_response']['tracking_number'] ??  $shipment->courier_shipment_id;
            $response = $this->courierService->trackShipment(
                $shipment->courierService->courier, 
                $trackingNumber
            );
            
            Log::info('Tracking response: ' . json_encode($response));
            
            if (isset($response['success']) && $response['success']) {
                // Update shipment status if available in response
                if (isset($response['status']) && $response['status'] !== $shipment->status) {
                    $shipment->update(['status' => $response['status']]);
                }
            }

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Shipment tracking failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Tracking failed: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Download shipment slip/label from courier service
     */
    public function downloadSlip(Shipment $shipment)
    {
        try {
            $trackingNumber = $shipment->tracking_number ?? $shipment->courier_response['raw_response']['tracking_number'] ?? null;
            
            if (!$trackingNumber) {
                return back()->with('error', 'No tracking number available for slip download');
            }

            $courier = $shipment->courierService->courier;
            
            // Get slip download information from unified courier service
            $result = $this->courierService->downloadSlip($courier, $trackingNumber, $shipment->courier_response);

            if (isset($result['error'])) {
                return back()->with('error', $result['error']);
            }

            // Handle different response types
            switch ($result['type']) {
                case 'redirect':
                    return redirect($result['url']);

                case 'content':
                    return response($result['content'], 200, [
                        'Content-Type' => $result['content_type'],
                        'Content-Disposition' => 'attachment; filename="' . $result['filename'] . '"',
                        'Content-Length' => strlen($result['content']),
                        'Cache-Control' => 'no-cache, no-store, must-revalidate',
                        'Pragma' => 'no-cache',
                        'Expires' => '0'
                    ]);

                case 'stream_auth':
                    return response()->streamDownload(function() use ($result) {
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $result['url']);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                            'Authorization: ' . $result['auth_header'],
                            'Accept: application/pdf'
                        ]);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
                        curl_setopt($ch, CURLOPT_HEADER, false);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
                        curl_setopt($ch, CURLOPT_WRITEFUNCTION, function($ch, $data) {
                            echo $data;
                            return strlen($data);
                        });
                        
                        $result = curl_exec($ch);
                        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                        
                        if ($result === false || $httpCode !== 200) {
                            Log::error('cURL error for Trax slip download: ' . curl_error($ch) . ' HTTP Code: ' . $httpCode);
                        }
                        
                        curl_close($ch);
                    }, $result['filename'], [
                        'Content-Type' => 'application/pdf'
                    ]);

                case 'stream':
                    return response()->streamDownload(function() use ($result) {
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $result['url']);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                            'Authorization: ' . $result['headers']['Authorization'],
                            'Accept: ' . $result['headers']['Accept']
                        ]);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                        $data = curl_exec($ch);
                        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                        curl_close($ch);
                        
                        if ($httpCode === 200 && $data !== false) {
                            echo $data;
                        } else {
                            // Log error for debugging
                            Log::error('Failed to download slip from Trax. HTTP Code: ' . $httpCode);
                            echo 'Error downloading slip';
                        }
                    }, $result['filename'], [
                        'Content-Type' => 'application/pdf'
                    ]);

                default:
                    return back()->with('error', 'Unknown download type');
            }

        } catch (\Exception $e) {
            Log::error('Slip download failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to download slip: ' . $e->getMessage());
        }
    }

    /**
     * Cancel shipment
     */
    public function cancel(Request $request, Shipment $shipment)
    {
        $request->validate([
            'cancellation_reason' => 'required|string|max:500'
        ]);

        try {
            if ($shipment->status === Shipment::STATUS_DELIVERED) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot cancel a delivered shipment'
                ]);
            }

            if ($shipment->courier_shipment_id) {
                $response = $this->courierService->cancelShipment(
                    $shipment->courierService->courier,
                    $shipment->courier_shipment_id
                );

                if (!$response['success']) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to cancel with courier: ' . $response['message']
                    ]);
                }
            }

            $shipment->update([
                'status' => Shipment::STATUS_CANCELLED,
                'cancelled_at' => now(),
                'cancellation_reason' => $request->cancellation_reason
            ]);

            // Update order status
            $shipment->order->update(['status' => 'cancelled']);

            return response()->json([
                'success' => true,
                'message' => 'Shipment cancelled successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Shipment cancellation failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Cancellation failed: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get cities for a specific courier service
     */
    public function getCities(Request $request)
    {
        $request->validate([
            'courier_service_id' => 'required|exists:courier_service_configs,id'
        ]);
    
        try {
            $courierService = CourierServiceConfig::find($request->courier_service_id);
            
            if (!$courierService) {
                return response()->json([
                    'success' => false,
                    'message' => 'Courier service not found'
                ]);
            }

            // Try to get cities from courier API
            $response = $this->courierService->getCities($courierService->courier);

            // If courier API failed, fallback to local cities
            if (isset($response['error']) || !is_array($response) || empty($response)) {
                $localCities = \App\Models\City::select('id', 'name')->get()->toArray();
                
                return response()->json([
                    'success' => true,
                    'data' => $localCities,
                    'source' => 'local'
                ]);
            }

            return response()->json([
                'success' => true,
                'data' => $response,
                'source' => 'api'
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to get cities for courier: ' . $e->getMessage());
            
            // Fallback to local cities on exception
            $localCities = \App\Models\City::select('id', 'name')->get()->toArray();
            
            return response()->json([
                'success' => true,
                'data' => $localCities,
                'source' => 'local_fallback'
            ]);
        }
    }

    /**
     * Get pickup addresses for a specific courier
     */
    public function getPickupAddresses(Request $request)
    {
        $request->validate([
            'courier' => 'required|string|in:trax,tcs,leopards'
        ]);

        try {
            $response = $this->courierService->getPickupAddresses($request->courier);

            if (isset($response['error'])) {
                return response()->json([
                    'success' => false,
                    'message' => $response['error'],
                    'addresses' => []
                ]);
            }

            return response()->json([
                'success' => true,
                'addresses' => $response['addresses'] ?? []
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to get pickup addresses for courier: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to load pickup addresses: ' . $e->getMessage(),
                'addresses' => []
            ]);
        }
    }
}
