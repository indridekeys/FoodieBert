<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Only add 'role' if it doesn't exist
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('customer');
            }
            
            // Only add 'matricule' if it doesn't exist
            if (!Schema::hasColumn('users', 'matricule')) {
                $table->string('matricule')->unique()->nullable();
            }

            // Only add 'picture' if it doesn't exist
            if (!Schema::hasColumn('users', 'picture')) {
                $table->string('picture')->nullable();
            }

            // Only add 'is_verified' if it doesn't exist
            if (!Schema::hasColumn('users', 'is_verified')) {
                $table->boolean('is_verified')->default(false);
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'matricule', 'picture', 'is_verified']);
        });
    }
};
