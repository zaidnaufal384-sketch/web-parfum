<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Kita panggil Model dengan lengkap untuk menghindari error
use App\Models\Product;
use App\Models\Note;
use App\Models\Category;

class FrontController extends Controller
{
    public function index()
    {
        // Menggunakan full path \App\Models\Product agar pasti ketemu
        $men_products = Product::where('gender', 'Men')->latest()->take(4)->get();
        $women_products = Product::where('gender', 'Women')->latest()->take(4)->get();
        $unisex_products = Product::where('gender', 'Unisex')->latest()->take(4)->get();

        return view('welcome', compact('men_products', 'women_products', 'unisex_products'));
    }

    public function details($slug)
    {
        $product = \App\Models\Product::with(['variants', 'notes'])
                        ->where('slug', $slug)
                        ->firstOrFail(); 

        return view('front.details', compact('product'));
    }

   public function catalog(Request $request)
{
    $query = \App\Models\Product::query();

    // 1. Filter Gender (Sudah ada)
    if ($request->has('gender') && $request->gender != null) {
        $query->where('gender', $request->gender);
    }

    // 2. Filter Note (Sudah ada)
    if ($request->has('note') && $request->note != null) {
        $query->whereHas('notes', function ($q) use ($request) {
            $q->where('name', $request->note);
        });
    }

   if ($request->has('sort')) {
    switch ($request->sort) {
        case 'price_asc':
            // Menggunakan subquery untuk mengambil harga terendah dari varian
            $query->addSelect(['min_price' => \App\Models\ProductVariant::select('price')
                ->whereColumn('product_id', 'products.id')
                ->orderBy('price', 'asc')
                ->limit(1)
            ])->orderBy('min_price', 'asc');
            break;

        case 'price_desc':
            // Menggunakan subquery untuk mengambil harga tertinggi dari varian
            $query->addSelect(['max_price' => \App\Models\ProductVariant::select('price')
                ->whereColumn('product_id', 'products.id')
                ->orderBy('price', 'desc')
                ->limit(1)
            ])->orderBy('max_price', 'desc');
            break;

        case 'name_asc':
            $query->orderBy('name', 'asc');
            break;

        default:
            $query->latest();
            break;
    }
} else {
    $query->latest();
}

    // Ambil data produk (Hapus ->latest() yang di bawah agar tidak bentrok dengan sorting)
    $products = $query->with(['variants', 'notes'])->get(); 
    $notes = \App\Models\Note::all(); 

    return view('front.catalog', compact('products', 'notes'));
}
    
   public function show($slug)
{
    // Mencari produk berdasarkan slug agar URL lebih rapi (SEO friendly)
    $product = Product::with(['category', 'variants', 'notes'])->where('slug', $slug)->firstOrFail();
    
    return view('product.show', compact('product'));
}
}