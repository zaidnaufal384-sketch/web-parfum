<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // Menampilkan daftar kategori
    public function index()
    {
        $categories = Category::all();
        // PERBAIKAN: Hapus 'pages.' karena file ada di folder admin/categories
        return view('admin.categories.index', compact('categories'));
    }

    // Menampilkan Form Tambah
    public function create()
    {
        // PERBAIKAN: Hapus 'pages.'
        return view('admin.categories.create'); 
    }

    // Memproses Penyimpanan Data
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:categories,slug', 
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    // --- TAMBAHAN UNTUK FITUR EDIT ---

    // 1. Menampilkan Form Edit
    // (Laravel otomatis mencari kategori berdasarkan ID yang diklik)
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // 2. Memproses Update Data ke Database
    public function update(Request $request, Category $category)
    {
        // Validasi input
        $data = $request->validate([
            'name' => 'required|string|max:255',
            // Validasi unik slug: "Boleh sama dengan slug lama miliknya sendiri, tapi tidak boleh sama dengan punya orang lain"
            'slug' => 'nullable|string|unique:categories,slug,' . $category->id,
        ]);

        // Logic pembuatan slug (sama seperti create)
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }

        // Simpan perubahan
        $category->update($data);

        // Kembali ke index
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Category $category)
    {
        // 1. Hapus data dari database
        $category->delete();

        // 2. Kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}