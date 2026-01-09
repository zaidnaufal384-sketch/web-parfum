<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Fungsi untuk menambah atau menghapus produk dari wishlist (Toggle).
     *
     */
    public function toggle(Request $request)
    {
        // 1. Pastikan user sudah login sebelum melakukan aksi
        if (!Auth::check()) {
            return response()->json([
                'status' => 'unauthorized',
                'message' => 'Silakan login untuk menyimpan wishlist.'
            ], 401);
        }

        $user = Auth::user();
        $productId = $request->product_id;

        // 2. Cek apakah produk sudah ada di daftar favorit user
        // Fungsi wishlists() harus sudah didefinisikan di model User
        $exists = $user->wishlists()->where('product_id', $productId)->exists();

        if ($exists) {
            // Jika sudah ada, maka hapus (Unlike)
            $user->wishlists()->detach($productId);
            return response()->json([
                'status' => 'removed',
                'message' => 'Produk dihapus dari wishlist.'
            ]);
        } else {
            // Jika belum ada, maka tambahkan (Like)
            $user->wishlists()->attach($productId);
            return response()->json([
                'status' => 'added',
                'message' => 'Produk berhasil disimpan ke wishlist.'
            ]);
        }
    }
    public function index()
{
    // Mengambil daftar produk yang telah ditambahkan ke wishlist oleh user yang sedang login
    // Pastikan relasi 'wishlists' sudah ada di model User
    $wishlists = auth()->user()->wishlists()->latest()->get();

    return view('wishlist.index', compact('wishlists'));
}
}