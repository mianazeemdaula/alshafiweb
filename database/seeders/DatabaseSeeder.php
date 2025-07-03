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

        // Call the CountrySeeder to add our restricted countries
        $this->call([
            CountrySeeder::class,
        ]);

        // Add states for Pakistan
        State::create(['country_id' => 1, 'name' => 'Punjab']);
        State::create(['country_id' => 1, 'name' => 'Sindh']);
        State::create(['country_id' => 1, 'name' => 'KPK']);
        State::create(['country_id' => 1, 'name' => 'Balochistan']);
        State::create(['country_id' => 1, 'name' => 'GB']);

        // Add states for Bahrain
        State::create(['country_id' => 2, 'name' => 'Capital']);
        State::create(['country_id' => 2, 'name' => 'Muharraq']);
        State::create(['country_id' => 2, 'name' => 'Northern']);
        State::create(['country_id' => 2, 'name' => 'Southern']);

        // Add states for Kuwait
        State::create(['country_id' => 3, 'name' => 'Kuwait City']);
        State::create(['country_id' => 3, 'name' => 'Hawalli']);
        State::create(['country_id' => 3, 'name' => 'Ahmadi']);

        // Add states for UAE
        State::create(['country_id' => 7, 'name' => 'Dubai']);
        State::create(['country_id' => 7, 'name' => 'Abu Dhabi']);
        State::create(['country_id' => 7, 'name' => 'Sharjah']);
        State::create(['country_id' => 7, 'name' => 'Ajman']);
        State::create(['country_id' => 7, 'name' => 'Fujairah']);
        
        // Add Some Cities for Pakistan
        City::create(['state_id' => 1, 'name' => 'Lahore']);
        City::create(['state_id' => 1, 'name' => 'Faisalabad']);
        City::create(['state_id' => 1, 'name' => 'Multan']);
        City::create(['state_id' => 1, 'name' => 'Rawalpindi']);
        City::create(['state_id' => 1, 'name' => 'Gujranwala']);

        // Add Some cities for UAE
        City::create(['state_id' => 13, 'name' => 'Dubai']);
        City::create(['state_id' => 14, 'name' => 'Abu Dhabi']);
        City::create(['state_id' => 15, 'name' => 'Sharjah']);
        City::create(['state_id' => 16, 'name' => 'Ajman']);
        City::create(['state_id' => 17, 'name' => 'Fujairah']);
        
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
