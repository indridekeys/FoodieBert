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
    Schema::table('users', function (Blueprint $table) {
        $table->string('role')->default('customer'); // super_admin, admin, delivery, customer
        $table->string('matricule')->unique()->nullable();
        $table->string('profile_photo')->nullable();
        $table->string('verification_code', 6)->nullable();
        $table->boolean('is_verified')->default(false);
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['role', 'matricule', 'profile_photo', 'verification_code', 'is_verified']);
    });
}
};
