<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('orders', function (Blueprint $table) {
        // The column missing in your error report
        $table->foreignId('agent_id')->nullable()->constrained('users')->onDelete('set null');
        
        // Status column for the 'pending_pickup' logic
        // Only add this if 'status' doesn't exist yet!
        if (!Schema::hasColumn('orders', 'status')) {
            $table->string('status')->default('pending_pickup');
        }
    });
}

public function down(): void
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn(['agent_id', 'status']);
    });
}
};
