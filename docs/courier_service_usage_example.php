<?php

// Example usage of the Unified Courier Service

use App\Services\UnifiedCourierService;

$courierService = new UnifiedCourierService();

// Example 1: Book a shipment with unified parameters
$bookingParams = [
    'pickup_name' => 'John Doe',
    'pickup_phone' => '03001234567',
    'pickup_email' => 'john@example.com',
    'pickup_address' => '123 Main Street, Karachi',
    'pickup_city_id' => 202, // Karachi ID
    'delivery_name' => 'Jane Smith',
    'delivery_phone' => '03009876543',
    'delivery_email' => 'jane@example.com',
    'delivery_address' => '456 Park Avenue, Lahore',
    'delivery_city_id' => 789, // Lahore ID
    'weight' => 2000, // Weight in grams
    'pieces' => 1,
    'cod_amount' => 1500, // Cash on delivery amount
    'order_id' => 'ORD-12345',
    'description' => 'T-shirt and jeans',
    'instructions' => 'Handle with care'
];

// Book with any courier using the same parameters
$traxResponse = $courierService->bookShipment('trax', $bookingParams);
$tcsResponse = $courierService->bookShipment('tcs', $bookingParams);
$leopardsResponse = $courierService->bookShipment('leopards', $bookingParams);

// Example 2: Track a shipment
$trackingNumber = 'TRX123456789';
$trackingResponse = $courierService->trackShipment('trax', $trackingNumber);

// Example 3: Cancel a shipment
$cancelResponse = $courierService->cancelShipment('trax', $trackingNumber);

// Example 4: Get cities for a courier
$cities = $courierService->getCities('leopards');

// Example 5: Get required parameters
$requiredParams = $courierService->getRequiredBookingParams();
/*
Returns:
[
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
]
*/

// Database Configuration Example
/*
To configure a courier, add a record to courier_service_configs table:

For Trax:
{
    "courier": "trax",
    "api_key": "your_trax_api_key",
    "extra": {
        "mode": "sandbox", // or "production"
        "sandbox_url": "https://app.sonic.pk/api",
        "production_url": "https://sonic.pk/api"
    }
}

For TCS:
{
    "courier": "tcs",
    "client_id": "your_tcs_account_id",
    "client_secret": "your_tcs_client_secret", 
    "token": "bearer_token_from_authentication",
    "extra": {
        "mode": "sandbox",
        "sandbox_url": "https://devconnect.tcscourier.com/ecom/api",
        "production_url": "https://ociconnect.tcscourier.com/ecom/api"
    }
}

For Leopards:
{
    "courier": "leopards",
    "api_key": "your_leopards_api_key",
    "api_password": "your_leopards_api_password",
    "extra": {
        "mode": "sandbox",
        "sandbox_url": "https://merchantapistaging.leopardscourier.com/api",
        "production_url": "https://merchantapi.leopardscourier.com/api"
    }
}
*/
