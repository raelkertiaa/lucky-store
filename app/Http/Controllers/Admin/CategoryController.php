<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    // GET /admin/kategori : daftar kategori + jumlah produknya
    public function index()
    {
        // withCount('products') menambahkan kolom products_count tanpa query tambahan per baris
        $categories = Category::withCount('products')->orderBy('name')->get();

        return view('admin.categories.index', compact('categories'));
    }

    // GET /admin/kategori/create : form kosong
    public function create()
    {
        // Form yang sama dipakai untuk tambah & edit. Untuk tambah, kirim objek kosong.
        return view('admin.categories.form', ['category' => new Category()]);
    }

    // POST /admin/kategori : simpan kategori baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:categories,name'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', "Kategori \"{$data['name']}\" ditambahkan.");
    }

    // GET /admin/kategori/{id}/edit : form berisi data lama.
    // Laravel otomatis mencari Category berdasarkan {id} di URL (Route Model Binding).
    // Kalau tidak ditemukan → otomatis 404.
    public function edit(Category $category)
    {
        return view('admin.categories.form', compact('category'));
    }

    // PUT /admin/kategori/{id} : simpan perubahan
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            // ignore($category->id): nama boleh sama dengan miliknya sendiri
            'name' => ['required', 'string', 'max:50', Rule::unique('categories', 'name')->ignore($category->id)],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori diperbarui.');
    }

    // DELETE /admin/kategori/{id}
    public function destroy(Category $category)
    {
        // Kategori yang masih dipakai produk tidak boleh dihapus
        if ($category->products()->withTrashed()->exists()) {
            return back()->with('error', "Kategori \"{$category->name}\" masih dipakai produk, tidak bisa dihapus.");
        }

        $category->delete();

        return back()->with('success', 'Kategori dihapus.');
    }
}