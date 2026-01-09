<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Note;
use App\Models\ProductVariant; 
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB; 


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'variants')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

   public function create()
    {
        // Ambil data kategori & notes untuk dikirim ke view
        $categories = Category::all();
        $notes = Note::all(); // 👈 Ambil semua data notes dari database

        return view('admin.products.create', compact('categories', 'notes'));
    }
    // --- FUNGSI SIMPAN UTAMA (FINAL) ---
   public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required',
            'brand'       => 'required',
            'gender'      => 'required',
            'description' => 'required',
            'image'       => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'notes'       => 'nullable|array', // 👈 Validasi array
            'notes.*'     => 'exists:notes,id', // 👈 Pastikan ID note valid
        ]);

        DB::transaction(function () use ($request) {
            
            // A. Simpan Data Produk
            $product = new Product();
            $product->name        = $request->name;
            $product->category_id = $request->category_id;
            $product->brand       = $request->brand;
            $product->gender      = $request->gender;
            $product->description = $request->description;
            
            $product->slug = Str::slug($request->name) . '-' . Str::random(4);
            
            // ❌ HAPUS BAGIAN IMPLODE LAMA
            // if ($request->has('notes')) { $product->notes = implode... } 

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('products', 'public');
                $product->image = $path;
            }

            $product->save(); // Simpan dulu agar punya ID

            // ✅ INI KODE BARU (Simpan Relasi Notes)
            if ($request->has('notes')) {
                $product->notes()->attach($request->notes);
            }

            // B. Simpan Varian Harga
            if ($request->has('sizes') && $request->has('prices')) {
                foreach ($request->sizes as $index => $size) {
                    $price = $request->prices[$index] ?? null;
                    $stock = $request->stocks[$index] ?? 0;
                    if (!empty($size) && !empty($price)) {
                        ProductVariant::create([
                            'product_id' => $product->id,
                            'size'       => $size,
                            'price'      => $price,
                            'stock'      => $stock,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('admin.products.index')->with('success', 'Produk Berhasil Disimpan!');
    }

    // --- FUNGSI EDIT & UPDATE ---
    public function edit(Product $product)
    {
        $categories = Category::all();
        $notes = Note::all();
        return view('admin.products.edit', compact('product', 'categories', 'notes'));
    }

  public function update(Request $request, Product $product)
    {
        // 1. Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required',
            'brand' => 'required',
            'gender' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'notes' => 'nullable|array',
            'notes.*' => 'exists:notes,id',
        ]);

        DB::transaction(function () use ($request, $product) {
            
            // 2. Update Data Produk Utama
            $product->name = $request->name;
            $product->slug = Str::slug($request->name);
            $product->category_id = $request->category_id;
            $product->brand = $request->brand;
            $product->gender = $request->gender;
            $product->description = $request->description;

            // ❌ HAPUS BAGIAN IMPLODE LAMA
            // if ($request->has('notes')) { $product->notes = implode... }

            // Cek jika ada upload foto baru
            if ($request->hasFile('image')) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                $path = $request->file('image')->store('products', 'public');
                $product->image = $path;
            }

            $product->save();

            // ✅ INI KODE BARU (Update Relasi Notes)
            // Sync akan otomatis menghapus yang tidak dicentang dan menambah yang dicentang
            $product->notes()->sync($request->input('notes', []));

            // 3. UPDATE VARIAN
            if ($request->has('sizes') && $request->has('prices')) {
                $product->variants()->delete();

                foreach ($request->sizes as $index => $size) {
                    $price = $request->prices[$index] ?? null;
                    $stock = $request->stocks[$index] ?? 0;
                    if (!empty($size) && !empty($price)) {
                        ProductVariant::create([
                            'product_id' => $product->id,
                            'size'       => $size,
                            'price'      => $price,
                            'stock'      => $stock,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('admin.products.index')->with('success', 'Produk Berhasil Diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk Dihapus');
    }

    public function show($id) {
    // Pastikan memanggil 'variants' agar data stok terbawa
    $product = Product::with(['variants', 'category', 'notes'])->findOrFail($id);
    return view('product.show', compact('product'));
}
}