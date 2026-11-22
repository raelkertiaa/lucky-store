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
    Schema::create('stock_movements', function (Blueprint $table) {
        $table->id();
        $table->foreignId('product_stock_id')->constrained()->cascadeOnDelete();
        // restock = masuk, sale_hold = terjual/di-hold, release = dikembalikan karena batal, adjustment = koreksi manual
        $table->enum('type', ['restock', 'sale_hold', 'release', 'adjustment']);
        $table->integer('quantity');                       // + masuk, - keluar
        $table->unsignedInteger('stock_after');            // saldo setelah perubahan
        // Tabel orders baru dibuat di Task 4, jadi relasinya (foreign key) ditambahkan nanti
        $table->unsignedBigInteger('order_id')->nullable()->index();
        $table->string('notes')->nullable();
        $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
        $table->timestamp('created_at')->useCurrent();     // riwayat tidak pernah diedit, cukup created_at
    });
}

public function down(): void
{
    Schema::dropIfExists('stock_movements');
}
};
