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

        // User Levels
        $levels = ['Sliver', 'Gold', 'Platinum', 'Diamond'];
        \App\Models\UserLevel::factory(count($levels))->create()->each(function ($level) use ($levels) {
            $level->name = $levels[$level->id - 1];
            $level->save();
        });

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
        ]);
        $user = User::find(1);
        $user->assignRole('admin');

        User::factory()->create([
            'name' => 'Support User',
            'email' => 'support@test.com',
        ]);
        $user = User::find(2);
        $user->assignRole('support');

        User::factory()->create([
            'name' => 'Normal User',
            'email' => 'user@test.com',
        ]);
        $user = User::find(3);
        $user->assignRole('user');


        // add countries and states
        Country::create(['name' => 'Pakistan', 'iso2' => 'PK', 'iso3' => 'PAK', 'phone_code' => '+92', 'currency' => 'PKR', 'currency_symbol' => 'Rs']);
        Country::create(['name' => 'United Arab Emirates', 'iso2' => 'AE', 'iso3' => 'UAE', 'phone_code' => '+971', 'currency' => 'AED', 'currency_symbol' => 'AED']);

        // Add states for Pakistan
        State::create(['country_id' => 1, 'name' => 'Punjab']);
        State::create(['country_id' => 1, 'name' => 'Sindh']);
        State::create(['country_id' => 1, 'name' => 'KPK']);
        State::create(['country_id' => 1, 'name' => 'Balochistan']);
        State::create(['country_id' => 1, 'name' => 'GB']);

        // Add states for UAE
        State::create(['country_id' => 2, 'name' => 'Dubai']);
        State::create(['country_id' => 2, 'name' => 'Abu Dhabi']);
        State::create(['country_id' => 2, 'name' => 'Sharjah']);
        State::create(['country_id' => 2, 'name' => 'Ajman']);
        State::create(['country_id' => 2, 'name' => 'Fujairah']);
        
        // Add Some Cities for Pakistan
        City::create(['state_id' => 1, 'name' => 'Lahore']);
        City::create(['state_id' => 1, 'name' => 'Faisalabad']);
        City::create(['state_id' => 1, 'name' => 'Multan']);
        City::create(['state_id' => 1, 'name' => 'Rawalpindi']);
        City::create(['state_id' => 1, 'name' => 'Gujranwala']);

        // Add Some ciites for UAE
        City::create(['state_id' => 6, 'name' => 'Dubai']);
        City::create(['state_id' => 6, 'name' => 'Sharjah']);
        City::create(['state_id' => 6, 'name' => 'Ajman']);
        City::create(['state_id' => 6, 'name' => 'Fujairah']);
        City::create(['state_id' => 6, 'name' => 'Ras Al Khaimah']);
        
        // Add Some Payment Methods
        \App\Models\PaymentMethod::factory(5)->create();

        // Categories 
        \App\Models\Category::factory(15)->create();
        // Products
        \App\Models\Product::factory(100)->create();

        $this->call([
            BlogCategorySeeder::class,
        ]);

        \App\Models\BlogPost::factory(100)->create();
        
    }
}
