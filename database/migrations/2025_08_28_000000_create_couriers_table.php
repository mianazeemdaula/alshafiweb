<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('courier_service_configs', function (Blueprint $table) {
            $table->id();
            $table->string('courier'); // trax, tcs, leopards
            $table->string('api_key')->nullable();
            $table->string('api_password')->nullable();
            $table->string('client_id')->nullable();
            $table->string('client_secret')->nullable();
            $table->text('token')->nullable();
            $table->timestamp('token_expiry')->nullable();
            $table->json('extra')->nullable(); // For mode, sandbox_url, production_url etc
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('courier_service_configs');
    }
};
