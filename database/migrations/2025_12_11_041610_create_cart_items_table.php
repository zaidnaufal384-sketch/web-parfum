<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            
            // Siapa yang punya keranjang ini?
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Produk apa? (Relasi ke tabel products)
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            
            // Ukuran & Harga yang mana? (Relasi ke tabel product_variants)
            $table->foreignId('product_variant_id')->constrained('product_variants')->onDelete('cascade');
            
            // Berapa banyak?
            $table->integer('quantity')->default(1);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};