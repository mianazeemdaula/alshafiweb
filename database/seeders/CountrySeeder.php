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
                'name' => 'Pakistan',
                'iso2' => 'PK',
                'iso3' => 'PAK',
                'phone_code' => '+92',
                'currency' => 'PKR',
                'currency_symbol' => '₨',
            ],
            [
                'name' => 'Bahrain',
                'iso2' => 'BH',
                'iso3' => 'BHR',
                'phone_code' => '+973',
                'currency' => 'BHD',
                'currency_symbol' => 'BD',
            ],
            [
                'name' => 'Kuwait',
                'iso2' => 'KW',
                'iso3' => 'KWT',
                'phone_code' => '+965',
                'currency' => 'KWD',
                'currency_symbol' => 'د.ك',
            ],
            [
                'name' => 'Oman',
                'iso2' => 'OM',
                'iso3' => 'OMN',
                'phone_code' => '+968',
                'currency' => 'OMR',
                'currency_symbol' => 'ر.ع.',
            ],
            [
                'name' => 'Qatar',
                'iso2' => 'QA',
                'iso3' => 'QAT',
                'phone_code' => '+974',
                'currency' => 'QAR',
                'currency_symbol' => 'ر.ق',
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
                'name' => 'United Arab Emirates',
                'iso2' => 'AE',
                'iso3' => 'ARE',
                'phone_code' => '+971',
                'currency' => 'AED',
                'currency_symbol' => 'د.إ',
            ],
            [
                'name' => 'Rest of the World',
                'iso2' => 'WW',
                'iso3' => 'WLD',
                'phone_code' => '+1',
                'currency' => 'USD',
                'currency_symbol' => 'RS.',
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
