<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\CourierServiceConfig;
use Illuminate\Support\Facades\Log;

class UnifiedCourierService
{
    const COURIERS = ['trax', 'tcs', 'leopards', 'manual'];

    /**
     * Book a shipment with unified parameters
     * 
     * @param string $courier
     * @param array $params - Unified parameters
     * @return array
     */
    public function bookShipment($courier, $params)
    {
        $requiredParams = [];
        if($courier === 'trax'){
            // remove pickup details because of Trax API requirements
            $requiredParams[] = 'pickup_address_id';
        }else if($courier == 'leopards'){
            $requiredParams = ['pickup_name', 'pickup_phone', 'pickup_address', 'pickup_city_id'];
        }

        $requiredParams = array_merge($requiredParams, [
            'delivery_name', 'delivery_phone', 'delivery_address', 'delivery_city_id',
            'weight', 'pieces', 'cod_amount', 'order_id', 'description', 'special_instructions'
        ]);
        
        foreach ($requiredParams as $param) {
            if (empty($params[$param])) {
                return [
                    'success' => false,
                    'status' => 'error',
                    'message' => "Missing required parameter: $param"
                ];
            }
        }

        switch ($courier) {
            case 'trax':
                return $this->bookTraxShipment($params);
            case 'tcs':
                return $this->bookTcsShipment($params);
            case 'leopards':
                return $this->bookLeopardsShipment($params);
            case 'manual':
                return [
                    'success' => true,
                    'tracking_number' => 'MANUAL-'.$params['manual_id'] ?? uniqid(),
                    'message' => 'Manual shipment recorded successfully',
                    'raw_response' => null
                ];
            default:
                return [
                    'success' => false,
                    'error' => 'Unsupported courier',
                    'message' => 'The selected courier is not supported'
                ];
        }
    }

    /**
     * Track a shipment
     */
    public function trackShipment($courier, $trackingNumber)
    {
        switch ($courier) {
            case 'trax':
                return $this->trackTraxShipment($trackingNumber);
            case 'tcs':
                return $this->trackTcsShipment($trackingNumber);
            case 'leopards':
                return $this->trackLeopardsShipment($trackingNumber);
            case 'manual':
                return [
                    'success' => true,
                    'status' => 'manual',
                    'tracking_number' => $trackingNumber,
                    'current_status' => 'This is a manual shipment. No tracking available.',
                    'shipper' => null,
                    'consignee' => null,
                    'pickup' => null,
                    'order_info' => null,
                    'tracking_history' => [],
                    'message' => 'Manual shipment. No tracking available.',
                    'raw_response' => null
                ];
            default:
                return ['error' => 'Unsupported courier'];
        }
    }

    /**
     * Cancel a shipment
     */
    public function cancelShipment($courier, $trackingNumber)
    {
        switch ($courier) {
            case 'trax':
                return $this->cancelTraxShipment($trackingNumber);
            case 'tcs':
                return $this->cancelTcsShipment($trackingNumber);
            case 'leopards':
                return $this->cancelLeopardsShipment($trackingNumber);
            default:
                return ['error' => 'Unsupported courier'];
        }
    }

    /**
     * Get shipment slip download URL or stream
     */
    public function downloadSlip($courier, $trackingNumber, $shipmentData = null)
    {
        switch ($courier) {
            case 'trax':
                return $this->downloadTraxSlip($trackingNumber);
            case 'tcs':
                return $this->downloadTcsSlip($trackingNumber);
            case 'leopards':
                return $this->downloadLeopardsSlip($trackingNumber, $shipmentData);
            default:
                return ['error' => 'Unsupported courier'];
        }
    }

    /**
     * Get cities for a courier
     */
    public function getCities($courier)
    {
        switch ($courier) {
            case 'trax':
                return $this->getTraxCities();
            case 'tcs':
                return $this->getTcsCities();
            case 'leopards':
                return $this->getLeopardsCities();
            case 'manual':
                return [
                    'success' => true,
                    'cities' => [
                        ['id' => 1, 'name' => 'Manual City'],
                    ]
                ];
            default:
                return ['error' => 'Unsupported courier'];
        }
    }

    /**
     * Get pickup addresses for a courier
     */
    public function getPickupAddresses($courier)
    {
        switch ($courier) {
            case 'trax':
                return $this->getTraxPickupAddresses();
            case 'tcs':
                return  [
                'success' => true,
                'addresses' => [
                    [
                        'id' => 'www.alShaafiOnline.com',
                        'address' => 'AL-Shaafi Dawakhana DPA',
                        'city' => [ 'name' =>'DEPAL PUR'],
                        'person_of_contact' => '03223236262',
                        'phone_number' => '03223236262'
                    ]
                ]
            ];
            case 'leopards':
                return ['error' => 'Pickup addresses not supported by this courier', 'addresses' => []];
            case 'manual':
                return [
                    'success' => true,
                    'addresses' => [
                        [
                            'id' => 1,
                            'address' => 'Manual Pickup Address',
                            'city' => [ 'name' =>'DepalPur'],
                            'person_of_contact' => 'Manual Contact',
                            'phone_number' => '0000000000'
                        ]
                    ]
                ];
            default:
                return ['error' => 'Unsupported courier'];
        }
    }

    public function getTcsPickupAddresses()
    {
        $config = $this->getConfig('tcs');
        if (!$config) return ['error' => 'TCS config not found', 'addresses' => []];

        $baseUrl = $this->getBaseUrl('tcs', $config);
        $sessionToken = $config->api_key;
        if(!$sessionToken){
            $res = Http::withToken($config->token)->get("$baseUrl/authentication/token", [
                'username' => env('TCS_API_USERNAME'),
                'password' => env('TCS_API_PASSWORD'),
            ]);
            $resData = $res->json();
            Log::info('TCS Auth Response:', $resData);
            $sessionToken = $resData['accesstoken'] ?? null;
            $config->api_key = $sessionToken;
            $config->save();
        }
        
        $response = Http::withHeaders([
            'Authorization' => "Bearer $config->token",
            'Accept' => 'application/json',
        ])->get("$baseUrl/inquiry/costcenterinquiry", [
            'tcsaccount' => 'MG03794',
            'accesstoken' => $sessionToken,
        ]);
        
        $result = $response->json();
        Log::info('TCS Pickup Addresses Response:', $result);
        if ($response->successful() && isset($result['message']) && $result['message'] === 'success') {
            return [
                'success' => true,
                'addresses' => $result['detail'] ?? []
            ];
        }
        
        return ['error' => 'Failed to fetch pickup addresses', 'addresses' => []];
    }

    /**
     * Add pickup address for a courier
     */
    public function addPickupAddress($courier, $params)
    {
        switch ($courier) {
            case 'trax':
                return $this->addTraxPickupAddress($params);
            case 'tcs':
            case 'leopards':
                return ['error' => 'Adding pickup addresses not supported by this courier'];
            default:
                return ['error' => 'Unsupported courier'];
        }
    }

    // TRAX Implementation
    protected function bookTraxShipment($params)
    {
        $config = $this->getConfig('trax');
        if (!$config) return ['error' => 'Trax config not found'];

        $baseUrl = $this->getBaseUrl('trax', $config);
        
        $payload = [
            // Mandatory fields according to Trax documentation
            'service_type_id' => 1, // Regular service
            'pickup_address_id' => $params['pickup_address_id'] ?? null,
            'information_display' => 1, // Show contact details on air waybill
            'consignee_city_id' => $params['delivery_city_id'],
            'consignee_name' => $params['delivery_name'],
            'consignee_address' => $params['delivery_address'],
            'consignee_phone_number_1' => $params['delivery_phone'],
            'consignee_email_address' => $params['delivery_email'] ?? '',
            'order_id' => $params['order_id'], // Optional but recommended
            'item_product_type_id' => 15, // General merchandise
            'item_description' => $params['description'],
            'item_quantity' => $params['pieces'],
            'item_insurance' => 0, // No insurance
            'item_price' => $params['cod_amount'],
            'pickup_date' => date('Y-m-d'),
            'estimated_weight' => (float)$params['weight'], // Weight in kg
            'shipping_mode_id' => 1, // Regular shipping
            'amount' => $params['cod_amount'],
            'payment_mode_id' => 1, // COD
            'charges_mode_id' => 4, // Standard charge mode
            
            // Optional fields
            'special_instructions' => $params['special_instructions'] ?? $params['instructions'], // Optional
            'open_shipment' => 0,
            'pieces_quantity' => $params['pieces']
        ];

        $response = Http::withHeaders([
            'Authorization' =>  $config->api_key,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->post("$baseUrl/shipment/book", $payload);

        $responseData = $response->json();
        Log::info('Trax Booking Response:', $responseData);
        
        // Normalize Trax response format to match expected format
        if (isset($responseData['status']) && $responseData['status'] === 0) {
            return [
                'success' => true,
                'tracking_number' => $responseData['tracking_number'] ?? null,
                'message' => $responseData['message'] ?? 'Shipment booked successfully',
                'raw_response' => $responseData
            ];
        } else {
            return [
                'success' => false,
                'message' => $responseData['message'] ?? 'Unknown error occurred',
                'raw_response' => $responseData
            ];
        }
    }

    protected function trackTraxShipment($trackingNumber)
    {
        $config = $this->getConfig('trax');
        if (!$config) return ['error' => 'Trax config not found'];

        $baseUrl = $this->getBaseUrl('trax', $config);
        
        $response = Http::withHeaders([
            'Authorization' => $config->api_key
        ])->get("$baseUrl/shipment/track", ['tracking_number' => $trackingNumber,'type' => 0]);

        $responseData = $response->json();
        
        // Normalize Trax tracking response
        if (isset($responseData['status']) && $responseData['status'] === 0) {
            $details = $responseData['details'] ?? [];
            $trackingHistory = $details['tracking_history'] ?? [];
            Log::info('Trax Tracking History:', $trackingHistory);
            
            // Get the latest status
            $latestStatus = !empty($trackingHistory) ? $trackingHistory[0]['status'] : 'Unknown';
            
            return [
                'success' => true,
                'status' => $this->mapTraxStatus($latestStatus),
                'tracking_number' => $details['tracking_number'] ?? $trackingNumber,
                'current_status' => $this->mapTraxStatus($latestStatus),
                'shipper' => $details['shipper'] ?? null,
                'consignee' => $details['consignee'] ?? null,
                'pickup' => $details['pickup'] ?? null,
                'order_info' => $details['order_information'] ?? null,
                'tracking_history' => $trackingHistory,
                'message' => $responseData['message'] ?? 'Tracking information retrieved successfully',
                'raw_response' => $responseData
            ];
        } else {
            return [
                'success' => false,
                'message' => $responseData['message'] ?? 'Failed to track shipment',
                'raw_response' => $responseData
            ];
        }
    }

    /**
     * Map Trax status to standard shipment status
     */
    private function mapTraxStatus($traxStatus)
    {
        $statusMap = [
            'Shipment - Booked' => 'booked',
            'Shipment - Arrived at Destination' => 'delivered',
            'Shipment - Cancelled' => 'cancelled',
            'Shipment - Arrived at Origin' => 'in_transit',
            'Shipment - In Transit' => 'in_transit',
            'Shipment - Booked' => 'booked',
            'Shipment - Arrived at Destination' => 'delivered',
            'Shipment - Out for Delivery' => 'out_for_delivery',
            'Shipment - Rider Exchanged' => 'out_for_delivery',
            'Shipment - Delivery Unsuccessful' => 'out_for_delivery',
            'Shipment - On Hold' => 'on_hold',
            'Shipment - Non-Service Area' => 'on_hold',
            'Shipment - Misrouted' => 'on_hold',
            'Shipment - Delivered' => 'delivered',
            'Shipment - Cancelled' => 'cancelled',
            'Shipment - Lost' => 'cancelled',
            'Return - Confirm' => 'returned',
            'Return - Delivered to Shipper' => 'returned',
            'Shipment - Received at Junction' => 'in_transit',
            'Shipment - Onward Forwarded' => 'in_transit',
            'Shipment - Arrival Service Center' => 'in_transit',
            'Shipment - Dispatched From Warehouse' => 'in_transit'
        ];

        return $statusMap[$traxStatus] ?? 'unknown';
    }

    /**
     * Map TCS status to standard shipment status
     */
    private function mapTcsStatus($tcsStatus)
    {
        $status = strtolower($tcsStatus);
        
        // Direct matches
        $statusMap = [
            'delivered' => 'delivered',
            'shipment delivered' => 'delivered',
            'in-process' => 'in_transit',
            'returned' => 'returned',
            'undelivered' => 'out_for_delivery',
            'on hold' => 'on_hold',
            'cancelled' => 'cancelled',
            'pickup' => 'booked',
            'in transit' => 'in_transit',
            'shipment picked up' => 'picked_up',
        ];
        Log::info('Mapping TCS Status:', ['status' => $status]);
        // Check direct match first
        if (isset($statusMap[$status])) {
            return $statusMap[$status];
        }

        Log::info('Mapping TCS Status fallback:', ['status' => $status]);
        
        // Pattern matching for complex statuses
        if (stripos($status, 'delivered') !== false) {
            return 'delivered';
        } elseif (stripos($status, 'out for delivery') !== false) {
            return 'out_for_delivery';
        } elseif (stripos($status, 'picked') !== false || stripos($status, 'picked up') !== false) {
            return 'picked_up';
        } elseif (stripos($status, 'arrived at') !== false || stripos($status, 'departed from') !== false) {
            return 'in_transit';
        } elseif (stripos($status, 'in transit') !== false) {
            return 'in_transit';
        } elseif (stripos($status, 'booked') !== false) {
            return 'booked';
        } elseif (stripos($status, 'return') !== false) {
            return 'returned';
        } elseif (stripos($status, 'cancel') !== false) {
            return 'cancelled';
        } elseif (stripos($status, 'hold') !== false || stripos($status, 'not available') !== false) {
            return 'on_hold';
        } else {
            return 'unknown';
        }
    }

    protected function cancelTraxShipment($trackingNumber)
    {
        $config = $this->getConfig('trax');
        if (!$config) return ['error' => 'Trax config not found'];

        $baseUrl = $this->getBaseUrl('trax', $config);
        
        $response = Http::withHeaders([
            'Authorization' => $config->api_key
        ])->post("$baseUrl/shipment/cancel", ['tracking_number' => $trackingNumber]);

        return $response->json();
    }

    protected function getTraxCities()
    {
        $config = $this->getConfig('trax');
        if (!$config) return ['error' => 'Trax config not found'];

        $baseUrl = $this->getBaseUrl('trax', $config);
        
        $response = Http::withHeaders([
            'Authorization' => $config->api_key
        ])->get("$baseUrl/cities");

        return $response->json();
    }

    protected function getTraxPickupAddresses()
    {
        $config = $this->getConfig('trax');
        if (!$config) return ['error' => 'Trax config not found', 'addresses' => []];

        $baseUrl = $this->getBaseUrl('trax', $config);
        
        $response = Http::withHeaders([
            'Authorization' => $config->api_key
        ])->get("$baseUrl/pickup_addresses");
        
        $result = $response->json();
        
        if ($response->successful() && isset($result['pickup_addresses'])) {
            return [
                'success' => true,
                'addresses' => $result['pickup_addresses']
            ];
        }
        
        return ['error' => 'Failed to fetch pickup addresses', 'addresses' => []];
    }

    protected function addTraxPickupAddress($params)
    {
        $config = $this->getConfig('trax');
        if (!$config) return ['error' => 'Trax config not found'];

        $baseUrl = $this->getBaseUrl('trax', $config);
        
        $data = [
            'person_of_contact' => $params['contact_name'],
            'phone_number' => $params['phone_number'], 
            'Email_address' => $params['email'],
            'address' => $params['address'],
            'city_id' => $params['city_id']
        ];
        
        $response = Http::withHeaders([
            'Authorization' => $config->api_key
        ])->post("$baseUrl/pickup_address/add", $data);
        
        $result = $response->json();
        
        if ($response->successful() && isset($result['status']) && $result['status'] == 0) {
            return [
                'success' => true,
                'message' => $result['message'] ?? 'Pickup address added successfully',
                'address_id' => $result['pickup_address_id'] ?? null
            ];
        }
        
        return [
            'error' => $result['message'] ?? 'Failed to add pickup address'
        ];
    }

    // TCS Implementation
    protected function bookTcsShipment($params)
    {
        $config = $this->getConfig('tcs');
        if (!$config) return ['error' => 'TCS config not found'];

        $baseUrl = $this->getBaseUrl('tcs', $config);
        if(!$config->api_key){
            $res = Http::withToken($config->token)->get("$baseUrl/authentication/token", [
                'username' => env('TCS_API_USERNAME'),
                'password' => env('TCS_API_PASSWORD'),
            ]);
            if($res->failed()){
                Log::error('TCS Authentication Failed:', $res->json());
            }
            $config->api_key = $res['accesstoken']; // Clear cached token to force re-authentication
            $config->save();
        }
        
        $payload = [
            'accesstoken' => $config->api_key,
            'consignmentno' => '', // Optional
            'shipperinfo' => [
                'tcsaccount' => 'MG03794',
                'shippername' => "AlShaafi Dawakhana",
                'address1' => "AL-Shaafi Dawakhana DPA",
                'countrycode' => 'PK',
                'countryname' => 'Pakistan',
                'cityname' => 'DEPAL PUR',
                'mobile' => "03223236262",
            ],
            'consigneeinfo' => [
                'firstname' => $params['delivery_name'],
                'middlename' => '', // Mandatory but can be empty
                'address1' => $params['delivery_address'],
                'countrycode' => 'PK',
                'countryname' => 'Pakistan',
                'citycode' => $params['delivery_city_id'] ?? 'Karachi',
                'mobile' => (function($phone){
                    $m = preg_replace('/\D/','', $phone ?? '');
                    if (strlen($m) === 10) $m = '0'.$m; // allow 10-digit numbers without leading zero
                    if (strlen($m) > 11) $m = substr($m, -11); // keep last 11 digits if extra chars
                    // Ensure pattern like 03xxxxxxxxx
                    if (preg_match('/^0[3]\d{9}$/', $m)) return $m;
                    // Fallback to original input if normalization fails
                    return $phone;
                })($params['delivery_phone']),
                'email' => $params['delivery_email'] ?? ''
            ],
                'shipmentinfo' => [
                // 'costcentercode' => "www.alShaafiOnline.com", // Mandatory - try generated or fallback to default
                'referenceno' => $params['order_id'],
                'contentdesc' => $params['description'],
                'servicecode' => 'O', // Overnight service code
                'currency' => 'PKR',
                'codamount' => (float)$params['cod_amount'], // Keep as rupees
                'weightinkg' => (float)$params['weight'], // Weight in kg
                'pieces' => (int)$params['pieces'],
                'fragile' => false,
                'remarks' => $params['special_instructions'] ?? '',
                'skus' => [
                    [
                        'description' => $params['description'],
                        'quantity' => (int)$params['pieces'],
                        'weight' => (float)$params['weight'], // Weight in kg
                        'uom' => 'KG',
                        'unitprice' => (float)$params['cod_amount'], // Keep as rupees
                        'declaredvalue' => null,
                        'insuredvalue' => null
                    ]
                ]
            ]
        ];

        Log::info('TCS Booking Payload:', $payload);
        $response = Http::withToken($config->token)
        ->post("$baseUrl/booking/create", $payload);

        $responseData = $response->json();
        Log::info('TCS Booking Response:', $responseData);
        // Normalize TCS response format to match expected format
        if (isset($responseData['message']) && $responseData['message'] === "SUCCESS") {
            return [
                'success' => true,
                'tracking_number' => $responseData['consignmentNo'] ?? null,
                'message' => $responseData['message'] ?? 'Shipment booked successfully',
                'raw_response' => $responseData
            ];
        } else {
            return [
                'success' => false,
                'message' => $responseData['message'] ?? 'Unknown error occurred',
                'raw_response' => $responseData
            ];
        }
    }

    protected function trackTcsShipment($trackingNumber)
    {
        $config = $this->getConfig('tcs');
        if (!$config) return ['error' => 'TCS config not found'];

        $baseUrl = $this->getBaseUrl('tcs', $config);
        
        $response = Http::withToken($config->token)
            ->get("https://ociconnect.tcscourier.com/tracking/api/Tracking/GetDynamicTrackDetail", ['consignee' => "$trackingNumber"]);
        $data = $response->json();
        Log::info('TCS Tracking Response:', $data);
        
        // Normalize TCS tracking response to match Leopards format
        if (isset($data['message']) && $data['message'] === 'SUCCESS') {
            $shipmentInfo = $data['shipmentinfo'][0] ?? [];
            $checkpoints = $data['checkpoints'] ?? [];
            $deliveryInfo = $data['deliveryinfo'] ?? [];
            
            // Get current status from most recent checkpoint or delivery info
            $currentStatusText = 'Unknown';
            $deliveredOn = null;
            $deliveredBy = null;
            
            if (!empty($deliveryInfo)) {
                $latestDelivery = $deliveryInfo[0];
                $currentStatusText = $latestDelivery['status'] ?? 'Unknown';
                // Check if delivered
                if (strtolower($latestDelivery['status'] ?? '') === 'delivered') {
                    $deliveredOn = $latestDelivery['datetime'] ?? null;
                    $deliveredBy = $latestDelivery['recievedby'] ?? null;
                }
            } elseif (!empty($checkpoints)) {
                $latestCheckpoint = $checkpoints[0];
                $currentStatusText = $latestCheckpoint['status'] ?? 'Unknown';
                
                // Check if delivered
                if (stripos($latestCheckpoint['status'] ?? '', 'delivered') !== false) {
                    $deliveredOn = $latestCheckpoint['datetime'] ?? null;
                    $deliveredBy = $latestCheckpoint['recievedby'] ?? null;
                }
            }
            
            // Map TCS status to standard status
            Log::info('Current TCS Status Text:', ['status' => $currentStatusText]);
            $mappedStatus = $this->mapTcsStatus($currentStatusText);
            
            // Format tracking history from checkpoints
            $trackingHistory = [];
            foreach ($checkpoints as $checkpoint) {
                $trackingHistory[] = [
                    'status' => $checkpoint['status'] ?? '',
                    'datetime' => $checkpoint['datetime'] ?? '',
                    'location' => $checkpoint['recievedby'] ?? '',
                    'remarks' => $checkpoint['status'] ?? ''
                ];
            }
            
            return [
                'success' => true,
                'status' => $mappedStatus,
                'tracking_number' => $shipmentInfo['consignmentno'] ?? $trackingNumber,
                'current_status' => $mappedStatus,
                'shipper' => [
                    'name' => $shipmentInfo['shipper'] ?? null,
                    'email' => null,
                    'phone' => null,
                    'address' => null
                ],
                'consignee' => [
                    'name' => $shipmentInfo['consignee'] ?? null,
                    'email' => null,
                    'phone' => null,
                    'address' => null
                ],
                'pickup' => [
                    'city' => $shipmentInfo['origin'] ?? null,
                    'country' => $shipmentInfo['origincountry'] ?? null
                ],
                'delivery' => [
                    'city' => $shipmentInfo['destination'] ?? null,
                    'delivered_on' => $deliveredOn,
                    'delivered_by' => $deliveredBy
                ],
                'order_info' => [
                    'booking_date' => $shipmentInfo['bookingdate'] ?? null,
                    'order_id' => $shipmentInfo['referenceno'] ?? null,
                    'weight' => null,
                    'pieces' => null,
                    'cod_amount' => null,
                    'special_instructions' => null
                ],
                'tracking_history' => $trackingHistory,
                'summary' => $data['shipmentsummary'] ?? null,
                'message' => 'Tracking information retrieved successfully',
                'raw_response' => $data
            ];
        } else {
            return [
                'success' => false,
                'message' => $data['message'] ?? 'Failed to track shipment',
                'raw_response' => $data
            ];
        }
    }

    protected function cancelTcsShipment($trackingNumber)
    {
        $config = $this->getConfig('tcs');
        if (!$config) return ['error' => 'TCS config not found'];

        $baseUrl = $this->getBaseUrl('tcs', $config);
        
        $response = Http::withToken($config->token)
            ->post("$baseUrl/booking/cancel", ['consignmentno' => $trackingNumber]);

        return $response->json();
    }

    protected function getTcsCities()
    {
        $config = $this->getConfig('tcs');
        if (!$config) return ['error' => 'TCS config not found'];

        $baseUrl = $this->getBaseUrl('tcs', $config);
        $response = Http::withToken($config->token)
        ->get("$baseUrl/setup/citylistbycountry", ['countrycode' => "PK"]);
        
        return $response->json()['data'] ?? [];
    }

    /**
     * Attempt to generate a TCS cost center code using configured endpoint or default endpoint
     * Returns cost center code string on success or null on failure
     */
    public function generateTcsCostCenter(CourierServiceConfig $config, $token = null)
    {
        try {
            $token = $config->token;
            $baseUrl = $this->getBaseUrl('tcs', $config);
            $url = "$baseUrl/booking/createcostcentercode";
            $response = Http::withToken($token)->timeout(20)->post($url, [
                'costcentercitname' => 'alshafionline',
                'costcentercode' => 'ALSHAFI123',
                'costcentername' => 'Alshafi Online',
                'pickupaddress' => 'Al-Shaafi Dawakhana DPA',
                'returnaddress' => 'Al-Shaafi Dawakhana DPA',
                'islabelprint' => true,
                'costcentercityname' => 'DEPAL PUR',
                'accountNumber' => 'MG03794',
                'accesstoken' => $token
            ]);
            Log::info('TCS Cost Center Generation Response:', $response->json());
            if ($response->successful()) {
                $data = $response->json();
                // Try common keys
                $code = $data['data']['costcentercode'] ?? $data['costcentercode'] ?? $data['costCenterCode'] ?? null;
                if ($code) {
                    Log::info('Generated TCS cost center code: '.$code);
                    return $code;
                }
            }
        } catch (\Exception $e) {
            Log::warning('TCS cost center generation failed: '.$e->getMessage());
        }

        return null;
    }

    // Leopards Implementation
    protected function bookLeopardsShipment($params)
    {
        $config = $this->getConfig('leopards');
        if (!$config) return ['error' => 'Leopards config not found'];

        $baseUrl = $this->getBaseUrl('leopards', $config);
        
        // Leopards required payload according to documentation
        $payload = [
            'api_key' => $config->api_key,
            'api_password' => $config->api_password,
            'booked_packet_weight' => (int)($params['weight'] * 1000), // Convert kg to grams for Leopards
            'booked_packet_no_piece' => (int)$params['pieces'],
            'booked_packet_collect_amount' => (float)$params['cod_amount'], // Keep as rupees
            'booked_packet_order_id' => $params['order_id'], // Optional
            'origin_city' => "1126",
            'destination_city' => $params['delivery_city_id'],
            'shipment_name_eng' => $params['pickup_name'],
            'shipment_email' => $params['pickup_email'] ?? '',
            'shipment_phone' => $params['pickup_phone'],
            'shipment_address' => $params['pickup_address'],
            'consignment_name_eng' => $params['delivery_name'],
            'consignment_email' => $params['delivery_email'] ?? '', // Optional
            'consignment_phone' => $params['delivery_phone'],
            'consignment_address' => $params['delivery_address'],
            'special_instructions' => $params['special_instructions'] ?? "MUST MAKE CALL TO THE CUSTOMER AND SHIPPER BEFORE RETURNING AND DON\'T FAKE REASON", // Optional
            'shipment_type' => 'overnight' // Default shipment type
        ];

        Log::info('Leopards Booking payload:', $payload);
        $response = Http::post("$baseUrl/bookPacket/format/json", $payload);

        $responseData = $response->json();
        Log::info('Leopards Booking Response:', $responseData);
        
        // Normalize Leopards response format to match expected format
        if (isset($responseData['status']) && $responseData['status'] === 1) {
            return [
                'success' => true,
                'tracking_number' => $responseData['track_number'] ?? null,
                'slip_link' => $responseData['slip_link'] ?? null,
                'message' => 'Shipment booked successfully',
                'raw_response' => $responseData
            ];
        } else {
            return [
                'success' => false,
                'message' => $responseData['error'] ?? 'Unknown error occurred',
                'raw_response' => $responseData
            ];
        }
    }

    protected function trackLeopardsShipment($trackingNumber)
    {
        $config = $this->getConfig('leopards');
        if (!$config) return ['error' => 'Leopards config not found'];

        $baseUrl = $this->getBaseUrl('leopards', $config);
        
        $payload = [
            'api_key' => $config->api_key,
            'api_password' => $config->api_password,
            'track_numbers' => $trackingNumber
        ];

        $response = Http::post("$baseUrl/trackBookedPacket/format/json", $payload);
        $responseData = $response->json();
        Log::info('Leopards Tracking Response:', $responseData);
        
        // Normalize Leopards tracking response
        if (isset($responseData['status']) && $responseData['status'] === 1) {
            $packetList = $responseData['packet_list'] ?? [];
            
            if (!empty($packetList)) {
                $packet = $packetList[0]; // Get first packet details
                $currentStatus = $packet['booked_packet_status'] ?? 'Unknown';
                $rawTracking = $packet['Tracking Detail'] ?? $packet['tracking_detail'] ?? $packet['tracking_details'] ?? [];
                $trackingDetails = [];

                foreach ($rawTracking as $t) {
                    $statusText = $t['Status'] ?? $t['status'] ?? '';
                    
                    // Build datetime (prefer Activity_datetime, else combine date + time)
                    $datetime = $t['Activity_datetime'] ?? null;
                    if (!$datetime) {
                        $date = $t['Activity_Date'] ?? $t['activity_date'] ?? null;
                        $time = $t['Activity_Time'] ?? $t['activity_time'] ?? null;
                        if ($date && $time) {
                            $datetime = trim("$date $time");
                        } elseif ($date) {
                            $datetime = $date;
                        } elseif (isset($t['datetime'])) {
                            $datetime = $t['datetime'];
                        } else {
                            $datetime = null;
                        }
                    }

                    // Normalize datetime to Y-m-d H:i:s when possible
                    $normalizedDatetime = null;
                    if ($datetime) {
                        $ts = strtotime($datetime);
                        $normalizedDatetime = $ts !== false ? date('Y-m-d H:i:s', $ts) : $datetime;
                    }

                    // Try to extract location from status text ("in CITY", "to CITY", "at CITY")
                    $location = null;
                    if (preg_match('/\b(?:in|to|at)\s+([A-Za-z0-9\s\-]+)/i', $statusText, $m)) {
                        $location = trim($m[1]);
                    } else {
                        // Fallback: last token if it looks like a place (contains letters)
                        $parts = preg_split('/\s+/', trim($statusText));
                        $last = end($parts);
                        if ($last && preg_match('/[A-Za-z]/', $last)) {
                            $location = $last;
                        }
                    }
                    $statusText = preg_replace('/\s+in\s+[A-Za-z0-9\s\-]+$/i', '', $statusText);
                    $trackingDetails[] = [
                        'status' => $statusText,
                        'datetime' => $normalizedDatetime,
                        'location' => $location,
                        'remarks' => $statusText
                    ];
                }
                
                return [
                    'success' => true,
                    'status' => $this->mapLeopardsStatus($currentStatus),
                    'tracking_number' => $packet['track_number'] ?? $trackingNumber,
                    'current_status' => $this->mapLeopardsStatus($currentStatus),
                    'shipper' => [
                        'name' => $packet['shipment_name_eng'] ?? null,
                        'email' => $packet['shipment_email'] ?? null,
                        'phone' => $packet['shipment_phone'] ?? null,
                        'address' => $packet['shipment_address'] ?? null
                    ],
                    'consignee' => [
                        'name' => $packet['consignment_name_eng'] ?? null,
                        'email' => $packet['consignment_email'] ?? null,
                        'phone' => $packet['consignment_phone'] ?? null,
                        'address' => $packet['consignment_address'] ?? null
                    ],
                    'pickup' => [
                        'city' => $packet['origin_city_name'] ?? null,
                        'country' => $packet['origin_country_name'] ?? null
                    ],
                    'delivery' => [
                        'city' => $packet['destination_city_name'] ?? null
                    ],
                    'order_info' => [
                        'booking_date' => $packet['booking_date'] ?? null,
                        'order_id' => $packet['booked_packet_order_id'] ?? null,
                        'weight' => $packet['booked_packet_weight'] ?? null,
                        'pieces' => $packet['booked_packet_no_piece'] ?? null,
                        'cod_amount' => $packet['booked_packet_collect_amount'] ?? null,
                        'special_instructions' => $packet['special_instructions'] ?? null
                    ],
                    'tracking_history' => $trackingDetails,
                    'message' => 'Tracking information retrieved successfully',
                    'raw_response' => $responseData
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'No tracking information found for this tracking number',
                    'raw_response' => $responseData
                ];
            }
        } else {
            return [
                'success' => false,
                'message' => $responseData['error'] ?? 'Failed to track shipment',
                'raw_response' => $responseData
            ];
        }
    }

    /**
     * Map Leopards status to standard shipment status
     */
    private function mapLeopardsStatus($leopardsStatus)
    {
        $statusMap = [
            'Pickup Request not Send' => 'booked',
            'Booked' => 'booked',
            'Picked' => 'picked_up',
            'In Transit' => 'in_transit',
            'Out for Delivery' => 'out_for_delivery',
            'Delivered' => 'delivered',
            'Returned' => 'returned',
            'Cancelled' => 'cancelled',
            'On Hold' => 'on_hold',
            'RTO' => 'returned',
            'Pickup Request not Send' => 'booked'
        ];

        return $statusMap[$leopardsStatus] ?? 'unknown';
    }

    protected function cancelLeopardsShipment($trackingNumber)
    {
        $config = $this->getConfig('leopards');
        if (!$config) return ['error' => 'Leopards config not found'];

        $baseUrl = $this->getBaseUrl('leopards', $config);
        
        $payload = [
            'api_key' => $config->api_key,
            'api_password' => $config->api_password,
            'cn_numbers' => $trackingNumber
        ];

        $response = Http::post("$baseUrl/cancelBookedPackets/format/json", $payload);

        return $response->json();
    }

    protected function getLeopardsCities()
    {
        $config = $this->getConfig('leopards');
        if (!$config) return ['error' => 'Leopards config not found'];

        $baseUrl = $this->getBaseUrl('leopards', $config);
        
        $payload = [
            'api_key' => $config->api_key,
            'api_password' => $config->api_password
        ];
        $response = Http::post("$baseUrl/getAllCities/format/json", $payload);
        $res =  $response->json();
        if (isset($res['status']) && $res['status'] == 1) {
            return $res['city_list'] ?? [];
        }
        return ['error' => 'Failed to fetch cities', 'cities' => []];
    }

    // Helper Methods
    protected function getConfig($courier)
    {
        return CourierServiceConfig::where('courier', $courier)->first();
    }

    protected function getBaseUrl($courier, $config)
    {
        $mode = $config->extra['mode'] ?? 'production';
        
        $urls = [
            'trax' => [
                'sandbox' => 'https://app.sonic.pk/api',
                'production' => 'https://sonic.pk/api'
            ],
            'tcs' => [
                'sandbox' => 'https://devconnect.tcscourier.com/ecom/api',
                'production' => 'https://ociconnect.tcscourier.com/ecom/api'
            ],
            'leopards' => [
                'sandbox' => 'https://merchantapistaging.leopardscourier.com/api',
                'production' => 'https://merchantapi.leopardscourier.com/api'
            ]
        ];

        return $urls[$courier][$mode];
    }

    /**
     * Get required parameters for booking
     */
    public function getRequiredBookingParams()
    {
        return [
            'pickup_name' => 'Shipper name',
            'pickup_phone' => 'Shipper phone',
            'pickup_email' => 'Shipper email', 
            'pickup_address' => 'Pickup address',
            'pickup_city_id' => 'Pickup city ID',
            'delivery_name' => 'Consignee name',
            'delivery_phone' => 'Consignee phone',
            'delivery_address' => 'Delivery address',
            'delivery_city_id' => 'Delivery city ID',
            'weight' => 'Weight in kilograms',
            'pieces' => 'Number of pieces',
            'cod_amount' => 'Cash on delivery amount',
            'order_id' => 'Your order reference',
            'description' => 'Item description'
        ];
    }

    /**
     * Download Trax shipment slip (air waybill)
     */
    private function downloadTraxSlip($trackingNumber)
    {
        $config = $this->getConfig('trax');
        if (!$config) {
            return ['error' => 'Trax configuration not found'];
        }

        $baseUrl = $this->getBaseUrl('trax', $config);
        
        try {
            // For Trax air waybill, use direct URL approach since binary content handling
            // through Laravel's HTTP client may cause issues
            $url = "{$baseUrl}/shipment/air_waybill?" . http_build_query([
                'tracking_number' => $trackingNumber,
                'type' => 1 // PDF format
            ]);
            
            // First verify the endpoint is working by making a test request
            $testResponse = Http::withHeaders([
                'Authorization' => $config->api_key,
                'Accept' => 'application/pdf'
            ])->timeout(30)->get($url);
            if ($testResponse->successful() && strlen($testResponse->body()) > 0) {
                // Return URL with authentication for direct streaming
                return [
                    'type' => 'stream_auth',
                    'url' => $url,
                    'auth_header' => $config->api_key,
                    'filename' => "trax-waybill-{$trackingNumber}.pdf"
                ];
            } else {
                return ['error' => 'Failed to get valid PDF from Trax API'];
            }
        } catch (\Exception $e) {
            Log::error('Trax slip download exception: ' . $e->getMessage());
            return ['error' => 'Failed to download slip: ' . $e->getMessage()];
        }
    }

    /**
     * Download TCS shipment label
     */
    private function downloadTcsSlip($trackingNumber)
    {
        $config = $this->getConfig('tcs');
        if (!$config) {
            return ['error' => 'TCS configuration not found'];
        }

        $baseUrl = $this->getBaseUrl('tcs', $config);
        $url = "{$baseUrl}/print/label?" . http_build_query([
            'consignmentno' => $trackingNumber,
            'shipperdetail' => 'true',
            'accesstoken' => $config->api_key
        ]);

        return [
            'type' => 'redirect',
            'url' => $url
        ];
    }

    /**
     * Download Leopards shipment slip
     */
    private function downloadLeopardsSlip($trackingNumber, $shipmentData = null)
    {
        // For Leopards, slip_link should be available in the booking response
        if ($shipmentData && isset($shipmentData['slip_link'])) {
            return [
                'type' => 'redirect',
                'url' => $shipmentData['slip_link']
            ];
        }

        return ['error' => 'Slip link not available from Leopards booking response'];
    }
}
