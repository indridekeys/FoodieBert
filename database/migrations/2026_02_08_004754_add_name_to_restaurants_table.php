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
        Schema::table('restaurants', function (Blueprint $table) {
            if (!Schema::hasColumn('restaurants', 'name')) {
                $table->string('name')->nullable();
            }
            if (!Schema::hasColumn('restaurants', 'category')) {
                $table->string('category')->nullable();
            }
            if (!Schema::hasColumn('restaurants', 'owner_name')) {
                $table->string('owner_name')->nullable();
            }
            if (!Schema::hasColumn('restaurants', 'location')) {
                $table->string('location')->nullable();
            }
            if (!Schema::hasColumn('restaurants', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('restaurants', 'image_url')) {
                $table->string('image_url')->nullable();
            }
            if (!Schema::hasColumn('restaurants', 'matricule')) {
                $table->string('matricule')->unique()->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn([
                'name', 
                'category', 
                'owner_name', 
                'location', 
                'description', 
                'image_url',
                'matricule'
            ]);
        });
    }
};