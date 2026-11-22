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
    Schema::create('product_sizes', function (Blueprint $table) {
        $table->id();
        $table->string('size_label', 20)->unique();   // "30ml"
        $table->decimal('price', 12, 2);              // harga jual
        $table->decimal('cost_price', 12, 2)->default(0); // harga modal
        $table->boolean('is_active')->default(true);
        $table->unsignedSmallInteger('sort_order')->default(0);
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('product_sizes');
}
};
