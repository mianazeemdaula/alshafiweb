<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, let's get all existing foreign keys on the orders table
        $database = DB::getDatabaseName();
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = ? 
            AND TABLE_NAME = 'orders' 
            AND REFERENCED_TABLE_NAME IS NOT NULL
            AND COLUMN_NAME = 'user_id'
        ", [$database]);

        // Drop any existing foreign key on user_id
        foreach ($foreignKeys as $fk) {
            DB::statement("ALTER TABLE `orders` DROP FOREIGN KEY `{$fk->CONSTRAINT_NAME}`");
        }

        Schema::table('orders', function (Blueprint $table) {
            // Modify user_id to be nullable
            $table->unsignedBigInteger('user_id')->nullable()->change();
            
            // Add manual customer fields if they don't exist
            if (!Schema::hasColumn('orders', 'customer_name')) {
                $table->string('customer_name')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('orders', 'customer_email')) {
                $table->string('customer_email')->nullable()->after('customer_name');
            }
            if (!Schema::hasColumn('orders', 'customer_phone')) {
                $table->string('customer_phone')->nullable()->after('customer_email');
            }
            
            // Add foreign key back with cascade to null
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // First, let's get all existing foreign keys on the orders table for user_id
        $database = DB::getDatabaseName();
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = ? 
            AND TABLE_NAME = 'orders' 
            AND REFERENCED_TABLE_NAME IS NOT NULL
            AND COLUMN_NAME = 'user_id'
        ", [$database]);

        // Drop any existing foreign key on user_id
        foreach ($foreignKeys as $fk) {
            DB::statement("ALTER TABLE `orders` DROP FOREIGN KEY `{$fk->CONSTRAINT_NAME}`");
        }

        Schema::table('orders', function (Blueprint $table) {
            // Remove manual customer fields if they exist
            if (Schema::hasColumn('orders', 'customer_name')) {
                $table->dropColumn('customer_name');
            }
            if (Schema::hasColumn('orders', 'customer_email')) {
                $table->dropColumn('customer_email');
            }
            if (Schema::hasColumn('orders', 'customer_phone')) {
                $table->dropColumn('customer_phone');
            }
            
            // Make user_id required again
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            
            // Add foreign key back with cascade delete
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};