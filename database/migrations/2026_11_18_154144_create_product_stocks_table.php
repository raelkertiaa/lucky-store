<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('product_stocks', function (Blueprint $table) {
        $table->id();
        $table->foreignId('product_id')->constrained()->cascadeOnDelete();
        $table->foreignId('product_size_id')->constrained()->cascadeOnDelete();
        $table->unsignedInteger('quantity')->default(0);          // jumlah botol tersedia
        $table->unsignedInteger('low_stock_threshold')->default(2); // batas "sisa sedikit"
        $table->timestamps();

        // Satu produk + satu ukuran hanya boleh punya SATU baris stok
        $table->unique(['product_id', 'product_size_id']);
    });
}

public function down(): void
{
    Schema::dropIfExists('product_stocks');
}
};
