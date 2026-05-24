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
        Schema::create('stock_item', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('products_id', 100)->nullable()->index(); // Barcode/Item code
            $table->integer('Amount')->default(0); // Quantity/Amount
            $table->string('Stock_Couse', 255)->nullable(); // Stock reason/cause
            $table->text('Note')->nullable(); // Additional notes
            $table->timestamp('Entry_Date')->useCurrent(); // Entry date

            // Timestamps

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_item');
    }
};
