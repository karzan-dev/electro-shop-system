<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('product_name'); // ناوی کاڵا لە کاتی فرۆشتن (ئەگەر دواتر ناوەکە گۆڕدرا)
            $table->decimal('purchase_price', 14, 2)->default(0); // نرخی کڕین لەو کاتە
            $table->decimal('selling_price', 14, 2)->default(0); // نرخی فرۆشتن لەو کاتە
            $table->integer('quantity')->default(1); // ژمارە
            $table->decimal('total', 14, 2)->default(0); // کۆی گشتی
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sale_items');
    }
};
