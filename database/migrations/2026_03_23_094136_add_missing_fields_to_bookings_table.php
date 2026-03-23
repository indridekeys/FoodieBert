<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('bookings', function (Blueprint $table) {
        if (!Schema::hasColumn('bookings', 'name')) {
            $table->string('name')->nullable();
        }
        if (!Schema::hasColumn('bookings', 'date')) {
            $table->date('date')->nullable();
        }
        if (!Schema::hasColumn('bookings', 'time')) {
            $table->time('time')->nullable();
        }
        if (!Schema::hasColumn('bookings', 'guests')) {
            $table->integer('guests')->default(1);
        }
    });
}

public function down(): void
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->dropColumn(['name', 'date', 'time', 'guests']);
    });
}
};
