<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // 1. Tampilkan Daftar Pesanan Masuk
   public function index(Request $request)
{
    // Gunakan query() agar bisa ditambah kondisi pencarian secara dinamis
    $query = Order::query();

    // Filter berdasarkan Status
    if ($request->has('status') && $request->status != '') {
        $query->where('status', $request->status);
    }

    // Filter berdasarkan Rentang Tanggal
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
    }

    // Ambil data terbaru
    $orders = $query->latest()->paginate(10);

    return view('admin.orders.index', compact('orders'));
}

    // 2. Lihat Detail Pesanan (Barang apa aja yang dibeli?)
    public function show(Order $order)
{
    // Mengambil data item dan produk agar admin bisa cek apa yang dibeli
    $order->load('items.product');
    return view('admin.orders.show', compact('order'));
}
    // 3. Update Status (Misal: dari Pending -> Shipped)
   // 3. Update Status
   public function update(Request $request, Order $order)
{
    // Validasi status baru yang dikirim dari tombol
    $request->validate([
        'status' => 'required|string'
    ]);

    $order->update([
        'status' => $request->status
    ]);

    return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui menjadi ' . $request->status);
}
}