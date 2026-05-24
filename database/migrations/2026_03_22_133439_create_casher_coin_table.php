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
        Schema::create('casher_coin', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->decimal('amount', 14, 2); // Amount field with precision
            $table->unsignedBigInteger('casher_id'); // Foreign key for casher
            $table->timestamps(); // Created at and updated at timestamps

            // Optional: Add foreign key constraint if you have a cashers table
            // $table->foreign('casher_id')->references('id')->on('cashers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('casher_coin');
    }
};
