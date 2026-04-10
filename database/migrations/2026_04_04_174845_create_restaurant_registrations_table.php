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
    Schema::create('restaurant_registrations', function (Blueprint $table) {
        $table->id();
        $table->string('establishment_name');
        $table->string('proprietor_name');
        $table->string('owner_email')->unique();
        $table->string('location_address')->default('Bertoua');
        $table->string('category'); 
        $table->text('description');
        $table->string('image')->nullable();
        $table->string('status')->default('pending'); 
        $table->timestamps();
    });
  }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_registrations');
    }
};
