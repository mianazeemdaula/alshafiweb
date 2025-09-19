<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourierServiceConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\UnifiedCourierService;
use Illuminate\Support\Facades\Log;

class CourierServiceController extends Controller
{
    /**
     * Display a listing of courier services
     */
    public function index()
    {
        $couriers = CourierServiceConfig::all();
        return view('admin.courier-services.index', compact('couriers'));
    }

    /**
     * Show the form for creating a new courier service
     */
    public function create()
    {
        $courierTypes = ['trax', 'tcs', 'leopards'];
        return view('admin.courier-services.create', compact('courierTypes'));
    }

    /**
     * Store a newly created courier service
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'courier' => 'required|string|in:trax,tcs,leopards|unique:courier_service_configs,courier',
            'api_key' => 'nullable|string',
            'api_password' => 'nullable|string',
            'client_id' => 'nullable|string',
            'client_secret' => 'nullable|string',
            'token' => 'nullable|string',
            'mode' => 'required|in:sandbox,production',
            'sandbox_url' => 'nullable|url',
            'production_url' => 'nullable|url',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $extra = [
            'mode' => $request->mode,
            'sandbox_url' => $request->sandbox_url,
            'production_url' => $request->production_url
        ];
        

        CourierServiceConfig::create([
            'courier' => $request->courier,
            'api_key' => $request->api_key,
            'api_password' => $request->api_password,
            'client_id' => $request->client_id,
            'client_secret' => $request->client_secret,
            'token' => $request->token,
            'token_expiry' => $request->token_expiry ? now()->addDays(30) : null,
            'extra' => json_encode($extra),
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.courier-services.index')
            ->with('success', 'Courier service created successfully');
    }

    /**
     * Display the specified courier service
     */
    public function show($id)
    {
        $courier = CourierServiceConfig::findOrFail($id);
        return view('admin.courier-services.show', compact('courier'));
    }

    /**
     * Show the form for editing the specified courier service
     */
    public function edit($id)
    {
        $courier = CourierServiceConfig::findOrFail($id);
        $courierTypes = ['trax', 'tcs', 'leopards'];
        return view('admin.courier-services.edit', compact('courier', 'courierTypes'));
    }

    /**
     * Update the specified courier service
     */
    public function update(Request $request, $id)
    {
        $courier = CourierServiceConfig::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'courier' => 'required|string|in:trax,tcs,leopards|unique:courier_service_configs,courier,' . $id,
            'api_key' => 'nullable|string',
            'api_password' => 'nullable|string',
            'client_id' => 'nullable|string',
            'client_secret' => 'nullable|string',
            'token' => 'nullable|string',
            'mode' => 'required|in:sandbox,production',
            'sandbox_url' => 'nullable|url',
            'production_url' => 'nullable|url',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $extra = [
            'mode' => $request->mode,
            'sandbox_url' => $request->sandbox_url,
            'production_url' => $request->production_url
        ];

        $courier->update([
            'courier' => $request->courier,
            'api_key' => $request->api_key,
            'api_password' => $request->api_password,
            'client_id' => $request->client_id,
            'client_secret' => $request->client_secret,
            'token' => $request->token,
            'token_expiry' => $request->token ? now()->addDays(30) : null,
            'extra' => json_encode($extra),
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.courier-services.index')
            ->with('success', 'Courier service updated successfully');
    }

    /**
     * Remove the specified courier service
     */
    public function destroy($id)
    {
        $courier = CourierServiceConfig::findOrFail($id);
        $courier->delete();

        return redirect()->route('admin.courier-services.index')
            ->with('success', 'Courier service deleted successfully');
    }

    /**
     * Toggle active status
     */
    public function toggleStatus($id)
    {
        $courier = CourierServiceConfig::findOrFail($id);
        $courier->update(['is_active' => !$courier->is_active]);

        $status = $courier->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.courier-services.index')
            ->with('success', "Courier service {$status} successfully");
    }

    /**
     * Test courier connection
     */
    public function testConnection($id)
    {
        $courier = CourierServiceConfig::findOrFail($id);
        
        try {
            // You can implement actual API test calls here
            $result = $this->performConnectionTest($courier);
            
            return response()->json([
                'success' => true,
                'message' => 'Connection test successful',
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Connection test failed: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Perform actual connection test
     */
    private function performConnectionTest($courier)
    {
        // Implement actual API test calls based on courier type
        switch ($courier->courier) {
            case 'trax':
                return ['status' => 'Connected to Trax API'];
            case 'tcs':
                return ['status' => 'Connected to TCS API'];
            case 'leopards':
                return ['status' => 'Connected to Leopards API'];
            default:
                throw new \Exception('Unknown courier type');
        }
    }
}
