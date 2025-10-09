<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class OrderTakerRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin role if it doesn't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        
        // Create order_taker role if it doesn't exist
        $orderTakerRole = Role::firstOrCreate(['name' => 'order_taker']);
        
        // Create support role if it doesn't exist
        $supportRole = Role::firstOrCreate(['name' => 'support']);
        
        // Create user role if it doesn't exist
        $userRole = Role::firstOrCreate(['name' => 'user']);
        
        // Create order_taker-specific permissions if they don't exist
        $orderTakerPermissions = [
            'view orders',
            'create orders',
            'edit orders',
            'view shipments',
            'create shipments',
            'edit shipments',
            'track shipments',
            'download shipment slip',
        ];
        
        foreach ($orderTakerPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        
        // Assign permissions to order_taker role
        $orderTakerRole->syncPermissions($orderTakerPermissions);
        
        // Admin permissions (full access)
        $adminPermissions = Permission::all();
        $adminRole->syncPermissions($adminPermissions);
        
        // Support role permissions (same as order_taker for now)
        $supportRole->syncPermissions($orderTakerPermissions);
        
        $this->command->info('Order taker role and permissions created successfully.');
    }
}
