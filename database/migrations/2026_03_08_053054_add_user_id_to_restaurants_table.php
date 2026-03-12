<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{public function up(): void
{
    Schema::table('restaurants', function (Blueprint $table) {
        // This adds the user_id column as a foreign key
        $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('restaurants', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->dropColumn('user_id');
    });
}
};
