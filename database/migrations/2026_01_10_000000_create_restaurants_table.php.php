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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            
            // Core Information
            $table->string('name')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->string('category')->nullable();
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            
            // Registration & Admin Fields
            $table->string('matricule')->unique()->nullable();
            $table->string('owner_name')->nullable();
            $table->string('owner_email')->nullable();
            
            // Operational Status
            $table->string('status')->default('closed'); // 'open' or 'closed'
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};