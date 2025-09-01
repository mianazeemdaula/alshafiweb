<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\CourierServiceConfig;

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
        // Validate required unified parameters
        $requiredParams = [
            'pickup_name', 'pickup_phone', 'pickup_email', 'pickup_address', 'pickup_city_id',
            'delivery_name', 'delivery_phone', 'delivery_address', 'delivery_city_id',
            'weight', 'pieces', 'cod_amount', 'order_id', 'description'
        ];
        
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

    // TRAX Implementation
    protected function bookTraxShipment($params)
    {
        $config = $this->getConfig('trax');
        if (!$config) return ['error' => 'Trax config not found'];

        $baseUrl = $this->getBaseUrl('trax', $config);
        
        $payload = [
            'service_type_id' => 1, // Regular service
            'pickup_address_id' => $params['pickup_address_id'] ?? null,
            'information_display' => 1,
            'consignee_city_id' => $params['delivery_city_id'],
            'consignee_name' => $params['delivery_name'],
            'consignee_address' => $params['delivery_address'],
            'consignee_phone_number_1' => $params['delivery_phone'],
            'consignee_email_address' => $params['delivery_email'] ?? '',
            'order_id' => $params['order_id'],
            'item_product_type_id' => 12, // General merchandise
            'item_description' => $params['description'],
            'item_quantity' => $params['pieces'],
            'item_insurance' => 0,
            'item_price' => $params['cod_amount'],
            'pickup_date' => date('Y-m-d'),
            'special_instructions' => $params['instructions'] ?? '',
            'estimated_weight' => $params['weight'],
            'shipping_mode_id' => 1,
            'amount' => $params['cod_amount'],
            'payment_mode_id' => 1, // COD
            'charges_mode_id' => 4,
            'open_shipment' => 0
        ];

        $response = Http::withHeaders([
            'Authorization' => $config->api_key,
            'Content-Type' => 'application/json'
        ])->post("$baseUrl/shipment/book", $payload);

        return $response->json();
    }

    protected function trackTraxShipment($trackingNumber)
    {
        $config = $this->getConfig('trax');
        if (!$config) return ['error' => 'Trax config not found'];

        $baseUrl = $this->getBaseUrl('trax', $config);
        
        $response = Http::withHeaders([
            'Authorization' => $config->api_key
        ])->get("$baseUrl/shipment/track", ['tracking_number' => $trackingNumber]);

        return $response->json();
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

    // TCS Implementation
    protected function bookTcsShipment($params)
    {
        $config = $this->getConfig('tcs');
        if (!$config) return ['error' => 'TCS config not found'];

        $baseUrl = $this->getBaseUrl('tcs', $config);
        
        $payload = [
            'accesstoken' => $config->token,
            'tcsaccount' => $config->client_id,
            'shippername' => $params['pickup_name'],
            'address1' => $params['pickup_address'],
            'countrycode' => 'PK',
            'countryname' => 'Pakistan',
            'cityname' => $params['pickup_city_name'] ?? 'Karachi',
            'mobile' => $params['pickup_phone'],
            'firstname' => $params['delivery_name'],
            'middlename' => '',
            'address1' => $params['delivery_address'],
            'cityname' => $params['delivery_city_name'] ?? 'Karachi',
            'mobile' => $params['delivery_phone'],
            'email' => $params['delivery_email'] ?? '',
            'productdetails' => $params['description'],
            'pieces' => $params['pieces'],
            'weight' => $params['weight'],
            'codamount' => $params['cod_amount'],
            'customerreferenceno' => $params['order_id'],
            'remarks' => $params['instructions'] ?? ''
        ];

        $response = Http::withToken($config->token)
            ->post("$baseUrl/booking/create", $payload);

        return $response->json();
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
        
        $payload = [
            'api_key' => $config->api_key,
            'api_password' => $config->api_password,
            'booked_packet_weight' => $params['weight'],
            'booked_packet_no_piece' => $params['pieces'],
            'booked_packet_collect_amount' => $params['cod_amount'],
            'booked_packet_order_id' => $params['order_id'],
            'origin_city' => $params['pickup_city_id'],
            'destination_city' => $params['delivery_city_id'],
            'shipment_name_eng' => $params['pickup_name'],
            'shipment_email' => $params['pickup_email'],
            'shipment_phone' => $params['pickup_phone'],
            'shipment_address' => $params['pickup_address'],
            'consignment_name_eng' => $params['delivery_name'],
            'consignment_email' => $params['delivery_email'] ?? '',
            'consignment_phone' => $params['delivery_phone'],
            'consignment_address' => $params['delivery_address'],
            'special_instructions' => $params['instructions'] ?? '',
            'shipment_type' => 'overnight'
        ];

        $response = Http::post("$baseUrl/bookPacket/format/json", $payload);

        return $response->json();
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
}
