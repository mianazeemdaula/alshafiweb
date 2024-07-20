<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'support']);
        Role::create(['name' => 'user']);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $user = User::find(1);
        $user->assignRole('admin');


        // add countries and states
        Country::create(['name' => 'Pakistan', 'iso2' => 'PK', 'iso3' => 'PAK', 'phone_code' => '+92', 'currency' => 'PKR', 'currency_symbol' => 'Rs']);
        Country::create(['name' => 'United States', 'iso2' => 'US', 'iso3' => 'USA', 'phone_code' => '+1', 'currency' => 'USD', 'currency_symbol' => '$']);

        // Add states

        State::create(['country_id' => 1, 'name' => 'Punjab']);
        State::create(['country_id' => 1, 'name' => 'Sindh']);
        State::create(['country_id' => 1, 'name' => 'KPK']);
        State::create(['country_id' => 1, 'name' => 'Balochistan']);
        State::create(['country_id' => 1, 'name' => 'GB']);

        // Add Some Cities

        City::create(['state_id' => 1, 'name' => 'Lahore']);
        City::create(['state_id' => 1, 'name' => 'Faisalabad']);
        City::create(['state_id' => 1, 'name' => 'Multan']);
        City::create(['state_id' => 1, 'name' => 'Rawalpindi']);
        City::create(['state_id' => 1, 'name' => 'Gujranwala']);

        // Categories 

        \App\Models\Category::factory(5)->create();
        // Products
        \App\Models\Product::factory(100)->create();
    }
}
