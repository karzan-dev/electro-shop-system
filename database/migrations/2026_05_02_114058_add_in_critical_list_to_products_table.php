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
        Schema::table('products', function (Blueprint $table) {
            // Add in_critical_list column
            $table->boolean('in_critical_list')->default(0)->after('selling_price');
            
            // Optional: Add timestamp for when product was added to critical list
            $table->timestamp('added_to_critical_list_at')->nullable()->after('in_critical_list');
            
            // Optional: Add notes about why product is in critical list
            $table->text('critical_list_notes')->nullable()->after('added_to_critical_list_at');
            
            // Add indexes for better performance
            $table->index('in_critical_list');
            $table->index('added_to_critical_list_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'in_critical_list',
                'added_to_critical_list_at',
                'critical_list_notes'
            ]);
        });
    }
};