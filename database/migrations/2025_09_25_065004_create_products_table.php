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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); //ts auto increments
            $table->string('title');  // Product title
            $table->text('description')->nullable();  // Product description
            $table->enum('category', ['arts', 'collectibles']);  // Product category (arts or collectibles)
            $table->decimal('price', 10, 2);  // Product price with 2 decimal places
            $table->string('image_url')->nullable();  // URL for the product image
            $table->timestamps();  // Created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
