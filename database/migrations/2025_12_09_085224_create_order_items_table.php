<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            
            // Produk apa? (Simpan ID Produk & ID Varian)
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); 
            $table->foreignId('product_variant_id')->constrained('product_variants')->onDelete('cascade');
            
            // Snapshot Harga & Jumlah
            $table->integer('quantity');
            $table->decimal('price', 15, 2); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};