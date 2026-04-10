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
    Schema::table('orders', function (Blueprint $table) {
        // Only add columns that DON'T exist yet in your DB
        if (!Schema::hasColumn('orders', 'item_name')) {
            $table->string('item_name')->after('restaurant_id')->nullable();
        }
        if (!Schema::hasColumn('orders', 'price')) {
            $table->decimal('price', 10, 2)->default(0);
        }
        if (!Schema::hasColumn('orders', 'quantity')) {
            $table->integer('quantity')->default(1);
        }
        if (!Schema::hasColumn('orders', 'status')) {
            $table->string('status')->default('pending');
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
