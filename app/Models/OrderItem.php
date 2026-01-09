<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    // --- TAMBAHKAN BARIS INI (PENTING) ---
    // Ini artinya: "Izinkan semua kolom diisi, tidak ada yang dijaga/dilarang"
    protected $guarded = []; 
    // -------------------------------------

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }
}