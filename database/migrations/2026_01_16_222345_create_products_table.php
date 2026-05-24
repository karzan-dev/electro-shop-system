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
            $table->string('name');
            $table->string('barcode')->unique();
            $table->string('company');
            $table->decimal('purchase_price', 20, 2);
            $table->decimal('selling_price', 20, 2);
            $table->integer('minimum_wearhouse')->default(0);
             $table->string('image_product_camera')->nullable();
            $table->string('image_producte_path')->nullable();
            $table->timestamps();
            // Add indexes for better performance
            $table->index(['barcode']);
            $table->index(['company']);
            $table->index(['created_at']);
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