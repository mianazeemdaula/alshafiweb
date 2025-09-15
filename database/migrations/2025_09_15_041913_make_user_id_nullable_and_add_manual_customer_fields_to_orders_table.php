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
        Schema::table('orders', function (Blueprint $table) {
            // Check if foreign key exists and drop it
            $this->dropForeignKeyIfExists('orders', 'orders_user_id_foreign');
            
            // Modify user_id to be nullable
            $table->unsignedBigInteger('user_id')->nullable()->change();
            
            // Add manual customer fields
            $table->string('customer_name')->nullable()->after('user_id');
            $table->string('customer_email')->nullable()->after('customer_name');
            $table->string('customer_phone')->nullable()->after('customer_email');
            
            // Add foreign key back with cascade to null
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Check if foreign key exists and drop it
            $this->dropForeignKeyIfExists('orders', 'orders_user_id_foreign');
            
            // Remove manual customer fields
            $table->dropColumn(['customer_name', 'customer_email', 'customer_phone']);
            
            // Make user_id required again
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            
            // Add foreign key back with cascade delete
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Check if foreign key exists and drop it safely
     */
    private function dropForeignKeyIfExists($table, $foreignKey)
    {
        $database = DB::getDatabaseName();
        
        $exists = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = ? 
            AND TABLE_NAME = ? 
            AND CONSTRAINT_NAME = ?
        ", [$database, $table, $foreignKey]);
        
        if (!empty($exists)) {
            DB::statement("ALTER TABLE `{$table}` DROP FOREIGN KEY `{$foreignKey}`");
        }
    }
};
