<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    // Order punya banyak barang (items)
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Order milik satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}