<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            
            // User yang beli
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Info Pengiriman (WAJIB ADA)
            $table->string('name');      // Nama Penerima Paket
            $table->string('phone');     // No WA Penerima
            $table->text('address');     // Alamat Lengkap
            
            // Data Transaksi
            $table->string('invoice_number')->unique(); // INV-2025xxx
            $table->decimal('total_price', 15, 2); 
            $table->enum('status', ['pending', 'paid', 'shipped', 'completed', 'cancelled'])->default('pending');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};