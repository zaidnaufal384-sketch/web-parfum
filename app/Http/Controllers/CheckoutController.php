<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // 👈 Wajib untuk fitur Transaksi

class CheckoutController extends Controller
{
    // 1. Tampilkan Halaman Checkout
    public function index()
    {
        // Ambil keranjang user
        $cartItems = CartItem::with(['product', 'variant'])
                    ->where('user_id', Auth::id())
                    ->get();

        foreach ($cartItems as $item) {
        if ($item->quantity > $item->variant->stock) {
            return redirect()->route('cart.index')->with('error', "Stok {$item->product->name} tidak mencukupi.");
        }
    }

        // Jika keranjang kosong, tendang balik ke katalog
        if ($cartItems->isEmpty()) {
            return redirect()->route('front.catalog');
        }

        // Hitung Total Bayar
        $total = $cartItems->sum(function($item) {
            return $item->variant->price * $item->quantity;
        });

        return view('front.checkout', compact('cartItems', 'total'));
    }

    // 2. Proses Simpan Pesanan (Store)
    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        // Gunakan Transaksi Database (Biar aman)
        DB::transaction(function () use ($request) {
            
            $userId = Auth::id();
            
            // A. Ambil Data Keranjang lagi
            $cartItems = CartItem::where('user_id', $userId)->get();
            $totalPrice = $cartItems->sum(function($item) {
                return $item->variant->price * $item->quantity;
            });

            // B. Buat Order Utama
            $order = Order::create([
                'user_id' => $userId,
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'total_price' => $totalPrice,
                'status' => 'pending',
                'invoice_number' => 'INV-' . time(), // Contoh: INV-17098822
            ]);

            // C. Pindahkan Item Keranjang ke OrderItems
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->product_variant_id,
                    'quantity' => $item->quantity,
                    'price' => $item->variant->price, // Harga saat beli
                ]);

                // 2. LOGIKA BARU: Kurangi stok pada varian produk
                 // Kita mencari varian yang tepat (misal: botol 100ml produk A)
                $variant = \App\Models\ProductVariant::find($item->product_variant_id);
                if ($variant) {
                    $variant->decrement('stock', $item->quantity);
                }
            }

            // D. Kosongkan Keranjang
            CartItem::where('user_id', $userId)->delete();
        });

        // Redirect ke halaman sukses
        return redirect()->route('checkout.success');
    }

    // 3. Halaman Sukses
    public function success()
    {
        return view('front.success');
    }
}