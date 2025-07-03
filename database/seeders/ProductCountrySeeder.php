<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Country;

class ProductCountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get countries
        $usa = Country::where('iso2', 'US')->first();
        $saudi = Country::where('iso2', 'SA')->first();
        $uk = Country::where('iso2', 'GB')->first();
        $eu = Country::where('iso2', 'EU')->first();

        // Get all products
        $products = Product::all();

        if ($products->count() === 0) {
            $this->command->info('No products found. Please run ProductSeeder first.');
            return;
        }

        // Distribute products across countries
        $countries = [$usa, $saudi, $uk, $eu];
        $countryIndex = 0;

        foreach ($products as $product) {
            if ($countries[$countryIndex]) {
                $product->update(['country_id' => $countries[$countryIndex]->id]);
            }
            
            // Cycle through countries
            $countryIndex = ($countryIndex + 1) % count($countries);
        }

        $this->command->info('Products have been distributed across countries.');
    }
}
