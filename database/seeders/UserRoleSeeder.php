<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create user role if it doesn't exist
        $userRole = Role::firstOrCreate(['name' => 'user']);
        
        // Create user-specific permissions if they don't exist
        $permissions = [
            'view own profile',
            'edit own profile',
            'view own orders',
            'cancel own orders',
            'write product reviews',
            'edit own reviews',
            'delete own reviews',
        ];
        
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        
        // Assign permissions to user role
        $userRole->syncPermissions($permissions);
        
        $this->command->info('User role and permissions created successfully.');
    }
}
