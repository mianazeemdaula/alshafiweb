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
        // Create specialist_penalties table to track non-delivery deductions
        Schema::create('specialist_penalties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('specialist_id')->comment('The specialist who receives the penalty');
            $table->unsignedBigInteger('order_id')->comment('The order that was not delivered');
            $table->integer('penalty_amount')->default(200)->comment('Penalty amount in PKR');
            $table->string('reason')->default('Non-Delivery')->comment('Reason for penalty');
            $table->enum('status', ['pending', 'applied', 'reversed'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamp('applied_at')->nullable();
            $table->timestamps();
            
            $table->foreign('specialist_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specialist_penalties');
    }
};
