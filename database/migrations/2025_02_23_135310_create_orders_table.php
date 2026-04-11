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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->nullable();
            $table->string('reference_num')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('quotation_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('sales_rep_id')->nullable();
            $table->string('shipping_address')->nullable();
            $table->double('price')->nullable();
            $table->double('quantity')->nullable();
            $table->string('status')->nullable();
            $table->string('delivery_type')->nullable();
            $table->string('proof_of_payment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
