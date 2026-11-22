<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductStock extends Model
{
    protected $fillable = ['product_id', 'product_size_id', 'quantity', 'low_stock_threshold'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(ProductSize::class, 'product_size_id');
    }

    public function movements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    // Status untuk label di katalog: "available" / "low" / "out"
    public function status(): string
    {
        return match (true) {
            $this->quantity <= 0 => 'out',
            $this->quantity <= $this->low_stock_threshold => 'low',
            default => 'available',
        };
    }
}