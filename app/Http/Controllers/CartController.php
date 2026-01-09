<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // 1. MENAMPILKAN ISI KERANJANG (API untuk Slide-Over)
    public function index()
    {
        $cartItems = CartItem::with(['product', 'variant'])
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->get();
        
        // Hitung Subtotal
        $subtotal = $cartItems->sum(function($item) {
            return $item->variant->price * $item->quantity;
        });

        return response()->json([
            'items' => $cartItems,
            'subtotal' => $subtotal,
            'count' => $cartItems->count()
        ]);
    }

    // 2. MENAMBAH BARANG (Add to Cart)
   public function store(Request $request)
{
    if (!Auth::check()) {
        return response()->json(['error' => 'Silakan login terlebih dahulu.'], 401);
    }

    $request->validate([
        'product_id' => 'required',
        'variant_id' => 'required',
    ]);

    // --- TAMBAHKAN PENGECEKAN STOK DI SINI ---
    $variant = \App\Models\ProductVariant::find($request->variant_id);
    
    if (!$variant || $variant->stock <= 0) {
        return response()->json(['error' => 'Maaf, stok parfum ini sudah habis.'], 422);
    }

    $existingItem = CartItem::where('user_id', Auth::id())
                            ->where('product_variant_id', $request->variant_id)
                            ->first();

    if ($existingItem) {
        // Cek apakah penambahan +1 akan melebihi stok yang ada
        if ($existingItem->quantity + 1 > $variant->stock) {
            return response()->json(['error' => 'Jumlah di keranjang sudah mencapai batas stok.'], 422);
        }
        $existingItem->increment('quantity');
    } else {
        CartItem::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'product_variant_id' => $request->variant_id,
            'quantity' => 1
        ]);
    }

    return response()->json(['message' => 'Produk berhasil masuk keranjang!']);
}
    // 3. MENGHAPUS BARANG
    public function destroy($id)
    {
        CartItem::where('id', $id)->where('user_id', Auth::id())->delete();
        return response()->json(['message' => 'Item dihapus']);
    }

    // 4. UPDATE QUANTITY (Tambah/Kurang)
   public function update(Request $request, $id)
{
    $cartItem = CartItem::with('variant')->where('id', $id)->where('user_id', Auth::id())->first();

    if ($cartItem) {
        // VALIDASI: Cek apakah jumlah yang diminta melebihi stok yang ada
        if ($request->quantity > $cartItem->variant->stock) {
            return response()->json([
                'error' => 'Maaf, stok tidak mencukupi. Sisa stok: ' . $cartItem->variant->stock
            ], 422);
        }

        $cartItem->update(['quantity' => $request->quantity]);
        return response()->json(['message' => 'Updated']);
    }

    return response()->json(['error' => 'Not found'], 404);
}
}