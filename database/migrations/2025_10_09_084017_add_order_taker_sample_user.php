<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create order_taker role if it doesn't exist
        $orderTakerRole = Role::firstOrCreate(['name' => 'order_taker']);
        
        // Create sample order_taker user
        $user = User::create([
            'name' => 'Order Taker',
            'email' => 'ordertaker@alshaafionline.com',
            'mobile' => '1234567890',
            'password' => bcrypt('password'),
            'ref_code' => 'ORDERTAKER',
            'extra_discount' => 0,
        ]);
        
        // Assign order_taker role
        $user->assignRole('order_taker');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the sample user
        $user = User::where('email', 'ordertaker@alshaafionline.com')->first();
        if ($user) {
            $user->delete();
        }
    }
};
