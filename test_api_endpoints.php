<?php

require_once 'vendor/autoload.php';

use App\Models\CourierServiceConfig;
use App\Services\UnifiedCourierService;

// Test script to verify API endpoints work correctly
echo "Testing Courier Service API Endpoints\n";
echo "=====================================\n\n";

// Initialize the service
$courierService = new UnifiedCourierService();

// Test 1: Check if courier configurations exist
echo "1. Testing Courier Service Configurations:\n";
$configs = CourierServiceConfig::where('is_active', true)->get();
foreach ($configs as $config) {
    echo "   - {$config->courier}: " . ($config->is_active ? 'Active' : 'Inactive') . "\n";
}
echo "\n";

// Test 2: Test pickup addresses for Trax
echo "2. Testing Pickup Addresses (Trax):\n";
try {
    $pickupResponse = $courierService->getPickupAddresses('trax');
    if (isset($pickupResponse['error'])) {
        echo "   Error: " . $pickupResponse['error'] . "\n";
    } else {
        $addresses = $pickupResponse['addresses'] ?? [];
        echo "   Found " . count($addresses) . " pickup addresses\n";
        if (count($addresses) > 0) {
            echo "   Sample address: " . $addresses[0]['person_of_contact'] . " - " . $addresses[0]['address'] . "\n";
        }
    }
} catch (Exception $e) {
    echo "   Exception: " . $e->getMessage() . "\n";
}
echo "\n";

// Test 3: Test cities for each courier
echo "3. Testing Cities for Each Courier:\n";
foreach ($configs as $config) {
    echo "   Testing {$config->courier}:\n";
    try {
        $citiesResponse = $courierService->getCities($config->courier);
        if (isset($citiesResponse['error'])) {
            echo "     Error: " . $citiesResponse['error'] . "\n";
        } else {
            if (is_array($citiesResponse)) {
                echo "     Found " . count($citiesResponse) . " cities\n";
                if (count($citiesResponse) > 0) {
                    $firstCity = $citiesResponse[0];
                    if (is_array($firstCity)) {
                        $cityName = $firstCity['name'] ?? $firstCity['city_name'] ?? $firstCity['title'] ?? 'Unknown';
                    } else {
                        $cityName = $firstCity;
                    }
                    echo "     Sample city: " . $cityName . "\n";
                }
            } else {
                echo "     Response type: " . gettype($citiesResponse) . "\n";
            }
        }
    } catch (Exception $e) {
        echo "     Exception: " . $e->getMessage() . "\n";
    }
}

echo "\nTest completed!\n";