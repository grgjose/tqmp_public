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
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->string('fulladdress')->nullable();
            $table->string('address')->nullable();
            $table->string('fullname')->nullable();
            $table->string('email')->nullable();
            $table->string('contact_num')->nullable();
            $table->string('instructions')->nullable();
            $table->double('delivery_fee')->nullable();
            $table->boolean('isDefault')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippings');
    }
};
