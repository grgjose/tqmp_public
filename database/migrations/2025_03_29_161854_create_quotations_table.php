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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('reference')->nullable();
            $table->string('quotation_type')->nullable();

            // For Bullet Proofing
            $table->string('plate_number')->nullable();
            $table->string('model')->nullable();
            $table->string('unit_color')->nullable();
            $table->json('services')->nullable();
            $table->string('remarks')->nullable();

            // For Glass Processing
            $table->json('type')->nullable();
            $table->json('thickness')->nullable();
            $table->json('h1')->nullable();
            $table->json('h2')->nullable();
            $table->json('w1')->nullable();
            $table->json('w2')->nullable();
            $table->json('quantity')->nullable();
            $table->json('color')->nullable();
            $table->json('cutting_details')->nullable();

            $table->string('filename_ar')->nullable();
            $table->string('filename_ar_signed')->nullable();
            $table->string('filename_conforme')->nullable();
            $table->string('filename_conforme_signed')->nullable();
            $table->string('filename_proof_of_payment')->nullable();
            $table->double('final_price')->nullable()->default(0.0);

            $table->string('status')->nullable();
            $table->boolean('isApprovedUser')->default(false)->nullable();
            $table->boolean('isApprovedSales')->default(false)->nullable();
            $table->boolean('isAddedToCart')->default(false)->nullable();

            $table->datetime('valid_until')->nullable();

            $table->string('cancel_remarks')->nullable();

            $table->boolean('isDeleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
