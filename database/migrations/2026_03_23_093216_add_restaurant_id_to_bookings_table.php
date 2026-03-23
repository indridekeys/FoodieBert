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
    Schema::table('bookings', function (Blueprint $table) {
        // Add the column and link it to the restaurants table
        $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->dropForeign(['restaurant_id']);
        $table->dropColumn('restaurant_id');
    });
}
};
