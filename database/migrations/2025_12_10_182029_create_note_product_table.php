<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel ini bertugas mencatat hubungan: Produk A punya Note apa saja?
        Schema::create('note_product', function (Blueprint $table) {
            $table->id();
            
            // Kunci Asing ke tabel products
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            
            // Kunci Asing ke tabel notes
            $table->foreignId('note_id')->constrained()->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('note_product');
    }
};