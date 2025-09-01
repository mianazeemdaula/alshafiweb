<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CourierServiceConfig;

class CourierServiceConfigSeeder extends Seeder
{
    public function run()
    {
        $couriers = [
            [
                'courier' => 'trax',
                'api_key' => null, // To be filled by admin
                'api_password' => null,
                'client_id' => null,
                'client_secret' => null,
                'token' => null,
                'token_expiry' => null,
                'extra' => json_encode([
                    'mode' => 'sandbox', // sandbox or production
                    'sandbox_url' => 'https://app.sonic.pk/api',
                    'production_url' => 'https://sonic.pk/api'
                ]),
                'is_active' => false
            ],
            [
                'courier' => 'tcs',
                'api_key' => null,
                'api_password' => null,
                'client_id' => null, // TCS Account ID
                'client_secret' => null, // TCS Client Secret
                'token' => null, // Access token from authentication
                'token_expiry' => null,
                'extra' => json_encode([
                    'mode' => 'sandbox',
                    'sandbox_url' => 'https://devconnect.tcscourier.com/ecom/api',
                    'production_url' => 'https://ociconnect.tcscourier.com/ecom/api'
                ]),
                'is_active' => false
            ],
            [
                'courier' => 'leopards',
                'api_key' => null, // Leopards API Key
                'api_password' => null, // Leopards API Password
                'client_id' => null,
                'client_secret' => null,
                'token' => null,
                'token_expiry' => null,
                'extra' => json_encode([
                    'mode' => 'sandbox',
                    'sandbox_url' => 'https://merchantapistaging.leopardscourier.com/api',
                    'production_url' => 'https://merchantapi.leopardscourier.com/api'
                ]),
                'is_active' => false
            ]
        ];

        foreach ($couriers as $courier) {
            CourierServiceConfig::updateOrCreate(
                ['courier' => $courier['courier']],
                $courier
            );
        }
    }
}
