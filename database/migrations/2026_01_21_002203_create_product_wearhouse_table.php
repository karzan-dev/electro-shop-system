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
        Schema::create('product_wearhouse', function (Blueprint $table) {
            $table->id(); // id primary key
            $table->unsignedBigInteger('id_product'); // foreign key to products
            $table->integer('counter')->default(0); // quantity in warehouse
            // foreign key constraint
            $table->foreign('id_product')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_wearhouse');
    }
};
