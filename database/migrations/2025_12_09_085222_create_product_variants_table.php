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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            
            // Terhubung ke tabel products
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            
            $table->string('size'); // Contoh: "5ml Decant", "100ml Full Bottle"
            $table->decimal('price', 10, 2); // Harga, misal: 50000.00
            $table->integer('stock'); // Stok per ukuran
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};