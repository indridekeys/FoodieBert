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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            // Connects the booking to a restaurant
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            
            $table->string('name');
            $table->date('date'); // Changed from booking_date to match form input
            $table->time('time'); // Changed from booking_time to match form input
            $table->integer('guests');
            $table->string('status')->default('pending'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};