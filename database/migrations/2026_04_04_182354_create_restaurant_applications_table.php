<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('restaurant_applications', function (Blueprint $table) {
        $table->id();
        $table->string('establishment_name');
        $table->string('proprietor_name');
        $table->string('owner_email');
        $table->text('location_address');
        $table->string('category');
        $table->string('image_path')->nullable(); // Matches controller: $imagePath
        $table->text('description')->nullable();
        $table->string('status')->default('pending'); 
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_applications');
    }
};
