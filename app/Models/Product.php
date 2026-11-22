<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id', 'name', 'slug', 'description',
        'image_path', 'promo_image_path',
        'is_best_seller', 'is_featured_banner', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_best_seller' => 'boolean',
            'is_featured_banner' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    // ===== Relasi =====

    // Kebalikan dari hasMany: produk ini milik satu kategori
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(ProductStock::class);
    }

    // ===== Scope =====

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    // ===== Accessor: URL gambar siap pakai di <img src="..."> =====
    // Pemakaian di Blade: {{ $product->image_url }}

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => $this->image_path
            ? Storage::url($this->image_path)
            : asset('images/product-placeholder.png'));
    }

    protected function promoImageUrl(): Attribute
    {
        return Attribute::get(fn () => $this->promo_image_path
            ? Storage::url($this->promo_image_path)
            : null);
    }

    // ===== Event otomatis =====

    protected static function booted(): void
    {
        // Sebelum disimpan: buat slug dari nama jika belum ada.
        // "Black Emotion" → "black-emotion" (ditambah angka jika sudah dipakai)
        static::saving(function (Product $product) {
            if (blank($product->slug) || $product->isDirty('name')) {
                $base = Str::slug($product->name);
                $slug = $base;
                $i = 2;
                while (static::withTrashed()->where('slug', $slug)->whereKeyNot($product->id)->exists()) {
                    $slug = "{$base}-{$i}";
                    $i++;
                }
                $product->slug = $slug;
            }
        });

        // Setelah produk baru dibuat: buat baris stok (0) untuk setiap ukuran
        static::created(function (Product $product) {
            ProductSize::pluck('id')->each(
                fn ($sizeId) => ProductStock::firstOrCreate([
                    'product_id' => $product->id,
                    'product_size_id' => $sizeId,
                ])
            );
        });
    }
}