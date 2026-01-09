<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relasi ke Produk (Untuk ambil Nama & Gambar)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke Varian (Untuk ambil Harga & Ukuran)
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
}