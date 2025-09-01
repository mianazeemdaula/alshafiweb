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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('courier_service_config_id')->constrained()->onDelete('cascade');
            $table->string('tracking_number')->nullable();
            $table->string('courier_shipment_id')->nullable();
            $table->enum('status', [
                'pending', 'booked', 'picked_up', 'in_transit', 
                'out_for_delivery', 'delivered', 'cancelled', 'returned'
            ])->default('pending');
            
            // Address information (JSON)
            $table->json('pickup_address');
            $table->json('delivery_address');
            
            // Package details
            $table->decimal('weight', 8, 3)->nullable(); // in kg
            $table->json('dimensions')->nullable(); // length, width, height in cm
            $table->decimal('declared_value', 10, 2)->nullable();
            $table->decimal('cod_amount', 10, 2)->nullable();
            
            // Additional information
            $table->text('special_instructions')->nullable();
            $table->json('courier_response')->nullable(); // Store API responses
            
            // Timestamps for status changes
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('tracking_number');
            $table->index('courier_shipment_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
