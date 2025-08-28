<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Courier;

class CourierService
{
    /**
     * Get required parameters for a courier and action
     */
    public function getRequiredParams($courier, $action)
    {
        $map = [
            'trax' => [
                'book' => ['person_of_contact', 'phone_number', 'email_address', 'address', 'city_id', 'parcel_details', 'receiver_name', 'receiver_phone', 'receiver_address', 'receiver_city_id'],
                'track' => ['tracking_number'],
                'cancel' => ['tracking_number'],
            ],
            'tcs' => [
                'book' => ['customer_name', 'customer_phone', 'customer_address', 'city_id', 'parcel_details', 'receiver_name', 'receiver_phone', 'receiver_address', 'receiver_city_id'],
                'track' => ['tracking_number'],
                'cancel' => ['tracking_number'],
            ],
            'leopards' => [
                'book' => ['shipper_name', 'shipper_phone', 'shipper_address', 'origin_city', 'parcel_details', 'consignee_name', 'consignee_phone', 'consignee_address', 'destination_city'],
                'track' => ['tracking_number'],
                'cancel' => ['tracking_number'],
            ],
        ];
        return $map[$courier][$action] ?? [];
    }
    const COURIERS = ['trax', 'tcs', 'leopards'];

    /**
     * Authenticate with a courier service
     */
    public function authenticate($courier)
    {
        switch ($courier) {
            case 'trax':
                return $this->handleTrax('authenticate', []);
            case 'tcs':
                return $this->handleTcs('authenticate', []);
            case 'leopards':
                return $this->handleLeopards('authenticate', []);
            default:
                return ['error' => 'Unsupported courier'];
        }
    }

    /**
     * Book a shipment
     */
    public function bookShipment($courier, $params)
    {
        switch ($courier) {
            case 'trax':
                return $this->handleTrax('book', $params);
            case 'tcs':
                return $this->handleTcs('book', $params);
            case 'leopards':
                return $this->handleLeopards('book', $params);
            default:
                return ['error' => 'Unsupported courier'];
        }
    }

    /**
     * Track a shipment
     */
    public function trackShipment($courier, $params)
    {
        switch ($courier) {
            case 'trax':
                return $this->handleTrax('track', $params);
            case 'tcs':
                return $this->handleTcs('track', $params);
            case 'leopards':
                return $this->handleLeopards('track', $params);
            default:
                return ['error' => 'Unsupported courier'];
        }
    }

    /**
     * Cancel a shipment
     */
    public function cancelShipment($courier, $params)
    {
        switch ($courier) {
            case 'trax':
                return $this->handleTrax('cancel', $params);
            case 'tcs':
                return $this->handleTcs('cancel', $params);
            case 'leopards':
                return $this->handleLeopards('cancel', $params);
            default:
                return ['error' => 'Unsupported courier'];
        }
    }

    /**
     * Trax API handler
     */
    protected function handleTrax($action, $params)
    {
        $config = Courier::where('courier', 'trax')->first();
        if (!$config) return ['error' => 'Trax config not found'];
        $mode = $config->extra['mode'] ?? 'production';
        $baseUrl = $mode === 'sandbox' ? ($config->extra['sandbox_url'] ?? 'https://app.sonic.pk/api') : ($config->extra['production_url'] ?? 'https://sonic.pk/api');
        $apiKey = $config->api_key;
        switch ($action) {
            case 'authenticate':
                return ['api_key' => $apiKey];
            case 'book':
                $response = Http::withHeaders(['Authorization' => $apiKey])
                    ->post("$baseUrl/book-shipment", $params);
                return $response->json();
            case 'track':
                $response = Http::withHeaders(['Authorization' => $apiKey])
                    ->get("$baseUrl/track-shipment", $params);
                return $response->json();
            case 'cancel':
                $response = Http::withHeaders(['Authorization' => $apiKey])
                    ->post("$baseUrl/cancel-shipment", $params);
                return $response->json();
            default:
                return ['error' => 'Unsupported action for Trax'];
        }
    }

    /**
     * TCS API handler
     */
    protected function handleTcs($action, $params)
    {
        $config = Courier::where('courier', 'tcs')->first();
        if (!$config) return ['error' => 'TCS config not found'];
        $mode = $config->extra['mode'] ?? 'production';
        $baseUrl = $mode === 'sandbox' ? ($config->extra['sandbox_url'] ?? 'https://devconnect.tcscourier.com/ecom/api') : ($config->extra['production_url'] ?? 'https://ociconnect.tcscourier.com/ecom/api');
        $clientId = $config->client_id;
        $clientSecret = $config->client_secret;
        $token = $config->token;
        switch ($action) {
            case 'authenticate':
                $response = Http::post("$baseUrl/auth", [
                    'clientid' => $clientId,
                    'clientsecret' => $clientSecret,
                ]);
                return $response->json();
            case 'book':
                $response = Http::withToken($token)
                    ->post("$baseUrl/booking/create", $params);
                return $response->json();
            case 'track':
                $response = Http::withToken($token)
                    ->get("$baseUrl/tracking", $params);
                return $response->json();
            case 'cancel':
                $response = Http::withToken($token)
                    ->post("$baseUrl/booking/cancel", $params);
                return $response->json();
            default:
                return ['error' => 'Unsupported action for TCS'];
        }
    }

    /**
     * Leopards API handler
     */
    protected function handleLeopards($action, $params)
    {
        $config = Courier::where('courier', 'leopards')->first();
        if (!$config) return ['error' => 'Leopards config not found'];
        $mode = $config->extra['mode'] ?? 'production';
        $baseUrl = $mode === 'sandbox' ? ($config->extra['sandbox_url'] ?? 'https://merchantapistaging.leopardscourier.com/api') : ($config->extra['production_url'] ?? 'https://merchantapi.leopardscourier.com/api');
        $apiKey = $config->api_key;
        $apiPassword = $config->api_password;
        switch ($action) {
            case 'authenticate':
                return ['api_key' => $apiKey, 'api_password' => $apiPassword];
            case 'book':
                $body = array_merge($params, [
                    'api_key' => $apiKey,
                    'api_password' => $apiPassword,
                ]);
                $response = Http::post("$baseUrl/bookPacket", $body);
                return $response->json();
            case 'track':
                $body = array_merge($params, [
                    'api_key' => $apiKey,
                    'api_password' => $apiPassword,
                ]);
                $response = Http::post("$baseUrl/trackBookedPacket", $body);
                return $response->json();
            case 'cancel':
                $body = array_merge($params, [
                    'api_key' => $apiKey,
                    'api_password' => $apiPassword,
                ]);
                $response = Http::post("$baseUrl/cancelBookedPacket", $body);
                return $response->json();
            default:
                return ['error' => 'Unsupported action for Leopards'];
        }
    }
}
