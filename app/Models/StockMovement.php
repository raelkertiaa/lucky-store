<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    // Tabel ini hanya punya created_at (tidak ada updated_at)
    const UPDATED_AT = null;

    protected $fillable = [
        'product_stock_id', 'type', 'quantity', 'stock_after',
        'order_id', 'notes', 'created_by',
    ];

    public function productStock(): BelongsTo
    {
        return $this->belongsTo(ProductStock::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function typeLabel(): string
    {
        return match ($this->type) {
            'restock' => 'Restock',
            'sale_hold' => 'Terjual',
            'release' => 'Dikembalikan',
            'adjustment' => 'Koreksi',
        };
    }
}