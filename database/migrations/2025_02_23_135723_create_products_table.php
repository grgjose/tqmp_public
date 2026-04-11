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
            $table->string('name')->nullable();
            $table->string('display_name')->nullable();
            $table->text('description')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('sub_category_id')->nullable();
            $table->string('brand')->nullable();
            $table->string('color')->nullable();
            $table->string('function')->nullable();
            $table->string('size')->nullable();
            $table->string('thickness')->nullable();
            $table->string('status')->nullable();
            $table->double('price')->nullable();
            $table->double('discounted_price')->nullable();
            $table->double('special_discounted_price')->nullable();
            $table->boolean('isDeleted')->nullable()->default(false);
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
