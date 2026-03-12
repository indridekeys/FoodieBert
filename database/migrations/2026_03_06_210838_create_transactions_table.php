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
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->decimal('amount', 12, 2); // Handles amounts up to 9,999,999,999.99
        $table->string('type')->default('delivery_fee'); // e.g., 'delivery_fee', 'bonus', 'withdrawal'
        $table->string('description')->nullable();
        $table->timestamps();
    });
}
   
};
