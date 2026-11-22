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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        // foreignId + constrained = kolom category_id yang terhubung ke tabel categories.
        // restrictOnDelete = kategori tidak bisa dihapus selama masih dipakai produk.
        $table->foreignId('category_id')->constrained()->restrictOnDelete();
        $table->string('name', 150);
        $table->string('slug', 170)->unique();            // untuk URL: /produk/black-emotion
        $table->text('description')->nullable();
        $table->string('image_path')->nullable();         // foto botol 1:1 (katalog)
        $table->string('promo_image_path')->nullable();   // poster promo (opsional)
        $table->boolean('is_best_seller')->default(false);
        $table->boolean('is_featured_banner')->default(false); // tampil di slider beranda
        $table->boolean('is_active')->default(true);
        $table->unsignedSmallInteger('sort_order')->default(0);
        $table->timestamps();
        $table->softDeletes();                            // kolom deleted_at
    });
}

public function down(): void
{
    Schema::dropIfExists('products');
}
};
