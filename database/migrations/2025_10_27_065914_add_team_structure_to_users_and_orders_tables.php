<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add team_leader_id to users table
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('team_leader_id')->nullable()->after('referrer');
            $table->foreign('team_leader_id')->references('id')->on('users')->onDelete('set null');
        });

        // Add order_taker_id and order_source to orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('order_taker_id')->nullable()->after('user_id')
                ->comment('The order taker who created this manual order');
            $table->enum('order_source', ['website', 'manual'])->default('website')->after('type')
                ->comment('Source of the order: website or manual entry');
            
            $table->foreign('order_taker_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['order_taker_id']);
            $table->dropColumn(['order_taker_id', 'order_source']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['team_leader_id']);
            $table->dropColumn('team_leader_id');
        });
    }
};
