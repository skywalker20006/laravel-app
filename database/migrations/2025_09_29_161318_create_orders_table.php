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
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // Auto-increment ID
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link to the users table
            $table->decimal('total_price', 10, 2); // Total price of the order
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending'); // Order status
            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
