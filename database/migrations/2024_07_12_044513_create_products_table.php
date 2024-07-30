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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('name', 100);
            $table->integer('weight')->default(0);
            $table->float('price')->default(0.0);
            $table->float('discount')->default(0.0);
            $table->float('vat')->default(0.0);
            $table->integer('stock')->default(1);
            $table->boolean('featured')->default(false);
            $table->text('description')->nullable();
            $table->string('extra_info', 200)->nullable();
            $table->integer('referrer_discount')->default(0);
            $table->integer('referal_discount')->default(0);
            $table->integer('buyer_discount')->default(0);
            $table->string('image');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
