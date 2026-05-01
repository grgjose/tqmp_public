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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
 
            // ── Parent order ──────────────────────────────────────────────────
            $table->unsignedBigInteger('order_id');
 
            // ── Item reference (one is set, the other is null) ────────────────
            $table->integer('product_id')->nullable();
            $table->integer('quotation_id')->nullable();
 
            // ── Pricing snapshot at time of order ─────────────────────────────
            // Always store prices as they were when the order was placed,
            // not the current live price on the product/quotation record.
            $table->integer('quantity');
            $table->double('unit_price');
            $table->double('discounted_price')->nullable();
 
            // ── Item-level fulfillment status ─────────────────────────────────
            // Independent from the parent order status.
            // e.g. Pending | Processing | Shipped | Delivered | Cancelled
            $table->string('status')->default('Pending');
 
            $table->string('remarks')->nullable();
 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
