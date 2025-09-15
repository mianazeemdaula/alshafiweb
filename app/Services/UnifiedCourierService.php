<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\CourierServiceConfig;
use Illuminate\Support\Facades\Log;

class UnifiedCourierService
{
    const COURIERS = ['trax', 'tcs', 'leopards'];

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
        }

        $requiredParams = array_merge($requiredParams, [
            'delivery_name', 'delivery_phone', 'delivery_address', 'delivery_city_id',
            'weight', 'pieces', 'cod_amount', 'order_id', 'description'
        ]);
        
        foreach ($requiredParams as $param) {
            if (empty($params[$param])) {
                return ['error' => "Missing required parameter: $param"];
            }
        }

        switch ($courier) {
            case 'trax':
                return $this->bookTraxShipment($params);
            case 'tcs':
                return $this->bookTcsShipment($params);
            case 'leopards':
                return $this->bookLeopardsShipment($params);
            default:
                return ['error' => 'Unsupported courier'];
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
            case 'leopards':
                return ['error' => 'Pickup addresses not supported by this courier', 'addresses' => []];
            default:
                return ['error' => 'Unsupported courier'];
        }
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
            'item_product_type_id' => 12, // General merchandise
            'item_description' => $params['description'],
            'item_quantity' => $params['pieces'],
            'item_insurance' => 0, // No insurance
            'item_price' => $params['cod_amount'],
            'pickup_date' => date('Y-m-d'),
            'estimated_weight' => (float)$params['weight'],
            'shipping_mode_id' => 1, // Regular shipping
            'amount' => $params['cod_amount'],
            'payment_mode_id' => 1, // COD
            'charges_mode_id' => 4, // Standard charge mode
            
            // Optional fields
            'special_instructions' => $params['instructions'] ?? '',
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
            
            // Get the latest status
            $latestStatus = !empty($trackingHistory) ? $trackingHistory[0]['status'] : 'Unknown';
            
            return [
                'success' => true,
                'status' => $this->mapTraxStatus($latestStatus),
                'tracking_number' => $details['tracking_number'] ?? $trackingNumber,
                'current_status' => $latestStatus,
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
            'In Transit' => 'in_transit',
            'Out for Delivery' => 'out_for_delivery',
            'Delivered' => 'delivered',
            'Returned' => 'returned',
            'Cancelled' => 'cancelled',
            'On Hold' => 'on_hold'
        ];

        return $statusMap[$traxStatus] ?? 'unknown';
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
        
        // TCS requires structured payload according to their documentation
        $payload = [
            'accesstoken' => $config->token,
            'consignmentno' => '', // Optional
            'shipperinfo' => [
                'tcsaccount' => $config->client_id,
                'shippername' => $params['pickup_name'],
                'address1' => $params['pickup_address'],
                'countrycode' => 'PK',
                'countryname' => 'Pakistan',
                'cityname' => $params['pickup_city_name'] ?? 'Karachi',
                'mobile' => $params['pickup_phone']
            ],
            'consigneeinfo' => [
                'firstname' => $params['delivery_name'],
                'middlename' => '', // Mandatory but can be empty
                'address1' => $params['delivery_address'],
                'countrycode' => 'PK',
                'countryname' => 'Pakistan',
                'cityname' => $params['delivery_city_name'] ?? 'Karachi',
                'mobile' => $params['delivery_phone'],
                'email' => $params['delivery_email'] ?? ''
            ],
            'shipmentinfo' => [
                'costcentercode' => 'DEFAULT', // Mandatory
                'referenceno' => $params['order_id'],
                'contentdesc' => $params['description'],
                'servicecode' => 'O', // Overnight service code
                'currency' => 'PKR',
                'codamount' => (int)$params['cod_amount'],
                'weightinkg' => (float)$params['weight'],
                'pieces' => (int)$params['pieces'],
                'fragile' => false,
                'remarks' => $params['instructions'] ?? '',
                'skus' => [
                    [
                        'description' => $params['description'],
                        'quantity' => (int)$params['pieces'],
                        'weight' => (float)$params['weight'],
                        'uom' => 'KG',
                        'unitprice' => (int)$params['cod_amount'],
                        'declaredvalue' => null,
                        'insuredvalue' => null
                    ]
                ]
            ]
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $config->token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->post("$baseUrl/booking/create", $payload);

        $responseData = $response->json();
        Log::info('TCS Booking Response:', $responseData);
        // Normalize TCS response format to match expected format
        if (isset($responseData['status']) && $responseData['status'] === true) {
            return [
                'success' => true,
                'tracking_number' => $responseData['result']['trackingno'] ?? null,
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
            ->get("$baseUrl/tracking", ['consignmentno' => $trackingNumber]);

        return $response->json();
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
            ->get("$baseUrl/setup/citylist");

        return $response->json();
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
            'booked_packet_weight' => (int)$params['weight'], // Weight in grams
            'booked_packet_no_piece' => (int)$params['pieces'],
            'booked_packet_collect_amount' => (int)$params['cod_amount'],
            'booked_packet_order_id' => $params['order_id'], // Optional
            'origin_city' => $params['pickup_city_id'],
            'destination_city' => $params['delivery_city_id'],
            'shipment_name_eng' => $params['pickup_name'],
            'shipment_email' => $params['pickup_email'] ?? '',
            'shipment_phone' => $params['pickup_phone'],
            'shipment_address' => $params['pickup_address'],
            'consignment_name_eng' => $params['delivery_name'],
            'consignment_email' => $params['delivery_email'] ?? '', // Optional
            'consignment_phone' => $params['delivery_phone'],
            'consignment_address' => $params['delivery_address'],
            'special_instructions' => $params['instructions'] ?? '', // Optional
            'shipment_type' => 'overnight' // Default shipment type
        ];

        $response = Http::post("$baseUrl/bookPacket/format/json", $payload);

        $responseData = $response->json();
        
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

        return $response->json();
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

        return $response->json();
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
            'weight' => 'Weight in grams',
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

        $baseUrl = $config->is_sandbox ? $config->sandbox_endpoint : $config->api_endpoint;
        $url = "{$baseUrl}/ecom/api/print/label?" . http_build_query([
            'consignmentno' => $trackingNumber,
            'shipperdetail' => 'true',
            'accesstoken' => $config->token
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
