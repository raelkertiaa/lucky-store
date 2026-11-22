<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductSize extends Model
{
    protected $fillable = ['size_label', 'price', 'cost_price', 'is_active', 'sort_order'];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'cost_price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(ProductStock::class);
    }

    // "Scope" = filter yang bisa dipakai ulang.
    // ProductSize::active()->get() → hanya ukuran aktif, urut sesuai sort_order
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Saat ukuran baru dibuat, otomatis buat baris stok (0) untuk SEMUA produk.
     * booted() dijalankan sekali saat model pertama kali dipakai.
     */
    protected static function booted(): void
    {
        static::created(function (ProductSize $size) {
            Product::withTrashed()->pluck('id')->each(
                fn ($productId) => ProductStock::firstOrCreate([
                    'product_id' => $productId,
                    'product_size_id' => $size->id,
                ])
            );
        });
    }
}