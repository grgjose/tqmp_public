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
 
            // ── Order identity ────────────────────────────────────────────────
            $table->string('reference_num')->unique()->nullable();
 
            // ── Parties ───────────────────────────────────────────────────────
            $table->integer('customer_id')->nullable();
            $table->integer('sales_rep_id')->nullable();
 
            // ── Delivery ──────────────────────────────────────────────────────
            $table->string('shipping_address')->nullable();
            $table->string('delivery_type')->nullable();     // pickup | delivery
 
            // ── Payment ───────────────────────────────────────────────────────
            $table->string('proof_of_payment')->nullable();  // one file per order
            $table->double('total_amount')->nullable();      // computed or stored total
 
            // ── Order-level status ────────────────────────────────────────────
            $table->string('status')->nullable();
 
            $table->timestamps();
            $table->softDeletes();
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
