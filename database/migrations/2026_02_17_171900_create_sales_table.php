<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique()->index(); // ژمارەی پسوڵە
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // فرۆشیار

            $table->decimal('subtotal', 14, 2)->default(0); // کۆی گشتی بەبێ داشکاندن

            $table->decimal('discount', 14, 2)->default(0); // بڕی داشکاندن

            $table->decimal('total', 14, 2)->default(0); // کۆی گشتی کۆتایی

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales');
    }
};
