<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product; // <--- INI YANG HILANG TADI
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
   public function index()
{
    // 1. Menghitung data dari database
    $totalProducts = Product::count();
    $totalOrders   = Order::count();
    $totalUsers    = User::count();
    
    // 2. Mengambil pesanan terbaru
    $recentOrders  = Order::with('user')->latest()->take(5)->get();

    // 3. Kirim SEMUA variabel ke view
    return view('admin.dashboard', compact(
        'totalProducts', 
        'totalOrders', 
        'totalUsers', 
        'recentOrders'
    ));
}
}