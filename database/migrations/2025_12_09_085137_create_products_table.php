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
            $table->id();
            
            // Relasi ke tabel categories
            // Jika kategori dihapus, produk di dalamnya ikut terhapus (cascade)
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            
            $table->string('name');
            $table->string('slug')->unique(); // Untuk URL ramah SEO
            $table->string('brand'); // Merk parfum
            $table->text('description'); // Deskripsi wangi (Top/Middle/Base notes)
            $table->string('gender'); // Pria/Wanita/Unisex
            $table->string('image')->nullable(); // Foto produk (bisa kosong dulu)
            
            $table->timestamps();
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