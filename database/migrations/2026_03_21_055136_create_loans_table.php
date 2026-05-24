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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sels_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('phone_number');
            $table->text('address');
            $table->string('currency');
            $table->decimal('period', 14, 2);
            $table->decimal('total', 14, 2);
            $table->date('time_to_return');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
