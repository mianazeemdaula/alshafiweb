<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            [
                'name' => 'United States',
                'iso2' => 'US',
                'iso3' => 'USA',
                'phone_code' => '+1',
                'currency' => 'USD',
                'currency_symbol' => '$',
            ],
            [
                'name' => 'Saudi Arabia',
                'iso2' => 'SA',
                'iso3' => 'SAU',
                'phone_code' => '+966',
                'currency' => 'SAR',
                'currency_symbol' => 'ر.س',
            ],
            [
                'name' => 'United Kingdom',
                'iso2' => 'GB',
                'iso3' => 'GBR',
                'phone_code' => '+44',
                'currency' => 'GBP',
                'currency_symbol' => '£',
            ],
            [
                'name' => 'European Union',
                'iso2' => 'EU',
                'iso3' => 'EUR',
                'phone_code' => '+33',
                'currency' => 'EUR',
                'currency_symbol' => '€',
            ],
            [
                'name' => 'United Arab Emirates',
                'iso2' => 'AE',
                'iso3' => 'ARE',
                'phone_code' => '+971',
                'currency' => 'AED',
                'currency_symbol' => 'د.إ',
            ],
            [
                'name' => 'Canada',
                'iso2' => 'CA',
                'iso3' => 'CAN',
                'phone_code' => '+1',
                'currency' => 'CAD',
                'currency_symbol' => 'C$',
            ],
            [
                'name' => 'Australia',
                'iso2' => 'AU',
                'iso3' => 'AUS',
                'phone_code' => '+61',
                'currency' => 'AUD',
                'currency_symbol' => 'A$',
            ],
            [
                'name' => 'India',
                'iso2' => 'IN',
                'iso3' => 'IND',
                'phone_code' => '+91',
                'currency' => 'INR',
                'currency_symbol' => '₹',
            ],
        ];

        foreach ($countries as $country) {
            Country::updateOrCreate(
                ['iso2' => $country['iso2']],
                $country
            );
        }
    }
}
