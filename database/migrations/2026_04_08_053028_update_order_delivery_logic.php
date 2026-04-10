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
    Schema::table('orders', function (Blueprint $table) {
        // Statuses: pending, accepted, rejected, preparing, out_for_delivery, completed
        $table->string('status')->default('pending')->change(); 
        $table->unsignedBigInteger('delivery_agent_id')->nullable(); 
        $table->text('delivery_address')->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
