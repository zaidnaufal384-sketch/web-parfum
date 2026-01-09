<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Halaman List Pesanan Saya
    public function index()
    {
        // Ambil order milik user yang sedang login, urutkan dari yang terbaru
        $orders = Order::where('user_id', Auth::id())
                        ->with('items.product') // Eager load biar ringan
                        ->latest()
                        ->get();

        return view('orders.index', compact('orders'));
    }

    // (Opsional) Halaman Detail Pesanan User
   public function show(Order $order)
{
    if ($order->user_id !== Auth::id()) {
        abort(403, 'Pesanan ini bukan milik Anda.');
    }

    // Pastikan item dan produk terbawa ke halaman detail
    $order->load('items.product'); 

    return view('orders.show', compact('order'));
}

// Menampilkan halaman instruksi transfer
public function payment(Order $order)
{
    if ($order->user_id !== Auth::id() || $order->status !== 'pending') {
        return redirect()->route('orders.history');
    }
    return view('orders.payment', compact('order'));
}

// Memproses upload bukti transfer
public function uploadPayment(Request $request, Order $order)
{
    $request->validate([
        'payment_proof' => 'required|image|max:2048'
    ]);

    if ($request->hasFile('payment_proof')) {
        $path = $request->file('payment_proof')->store('payments', 'public');
        
        $order->update([
            'payment_proof' => $path,
            'status' => 'waiting_verification' // Ubah status agar tombol bayar hilang
        ]);
    }

    return redirect()->route('orders.show', $order->id)->with('success', 'Bukti transfer berhasil diunggah!');
}

    public function history()
{
    // Mengambil pesanan milik user yang sedang login, diurutkan dari yang terbaru
    $orders = Order::where('user_id', auth()->id())
                    ->orderBy('created_at', 'desc')
                    ->get();

    return view('orders.history', compact('orders'));
}


}
