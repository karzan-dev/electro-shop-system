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
        Schema::create('return_items', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('Item_Code', 100)->nullable(); // Item code/barcode
            $table->decimal('Amount', 14, 2)->default(0.00); // Return amount
            $table->text('Metar')->nullable(); // Notes/description
            $table->decimal('Sale_Price', 14, 2)->default(0.00); // Sale price at return
            $table->decimal('Return_Total', 14, 2)->default(0.00); // Total return amount
            $table->text('Return_Cause')->nullable(); // Reason for return
            $table->string('Casher', 100)->nullable(); // Cashier who processed return
            $table->timestamp('Return_Date')->useCurrent(); // Return date and time

            $table->foreign('Item_Code')->references('barcode')->on('items');

            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_items');
    }
};
