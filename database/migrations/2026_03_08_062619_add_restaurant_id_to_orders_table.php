<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    if (!Schema::hasColumn('orders', 'restaurant_id')) {
        Schema::table('orders', function (Table $table) {
            $table->foreignId('restaurant_id')->constrained();
        });
    }
}

/**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop the foreign key constraint first (PostgreSQL requirement)
            $table->dropForeign(['restaurant_id']);
            // Then drop the column
            $table->dropColumn('restaurant_id');
        });
    }
};
