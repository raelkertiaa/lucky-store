<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductSizeController extends Controller
{
    public function index()
    {
        $sizes = ProductSize::orderBy('sort_order')->get();

        return view('admin.sizes.index', compact('sizes'));
    }

    public function create()
    {
        return view('admin.sizes.form', ['size' => new ProductSize(['is_active' => true])]);
    }

    public function store(Request $request)
    {
        ProductSize::create($this->validated($request));

        return redirect()->route('admin.sizes.index')->with('success', 'Ukuran ditambahkan. Stok 0 dibuat untuk semua produk.');
    }

    public function edit(ProductSize $size)
    {
        return view('admin.sizes.form', compact('size'));
    }

    public function update(Request $request, ProductSize $size)
    {
        $size->update($this->validated($request, $size));

        return redirect()->route('admin.sizes.index')->with('success', 'Ukuran & harga diperbarui.');
    }

    public function destroy(ProductSize $size)
    {
        // Masih ada stok di ukuran ini → tolak, sarankan nonaktifkan
        if ($size->stocks()->where('quantity', '>', 0)->exists()) {
            return back()->with('error', "Ukuran {$size->size_label} masih punya stok. Nonaktifkan saja jika tidak dijual lagi.");
        }

        $size->delete();

        return back()->with('success', 'Ukuran dihapus.');
    }

    /**
     * Validasi dipakai bersama oleh store() dan update().
     */
    private function validated(Request $request, ?ProductSize $size = null): array
    {
        // Owner mungkin mengetik "50.000" → buang titik/huruf, sisakan angka
        $request->merge([
            'price' => preg_replace('/\D/', '', (string) $request->price),
            'cost_price' => preg_replace('/\D/', '', (string) $request->cost_price),
        ]);

        $data = $request->validate([
            'size_label' => ['required', 'string', 'max:20', Rule::unique('product_sizes')->ignore($size?->id)],
            'price' => ['required', 'integer', 'min:1000'],
            'cost_price' => ['required', 'integer', 'min:0', 'lte:price'], // modal tidak boleh > harga jual
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [
            'cost_price.lte' => 'Harga modal tidak boleh lebih besar dari harga jual.',
        ], [
            'size_label' => 'label ukuran',
            'price' => 'harga jual',
            'cost_price' => 'harga modal',
        ]);

        // Checkbox yang tidak dicentang tidak terkirim sama sekali → pakai boolean()
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] ??= 0;

        return $data;
    }
}