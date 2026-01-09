<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    // KITA PAKAI $guarded = [] AGAR SEMUA KOLOM (size, price, stock) BISA DISIMPAN
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}