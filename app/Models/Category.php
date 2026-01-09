<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // WAJIB ADA: Agar kolom name dan slug bisa diisi dari form
    protected $fillable = [
        'name',
        'slug',
    ];
}