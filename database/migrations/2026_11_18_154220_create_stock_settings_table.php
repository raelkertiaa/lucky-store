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
    // Tabel key–value: satu baris = satu pengaturan.
    // Contoh: key "bank_account", value "1234567890"
    Schema::create('settings', function (Blueprint $table) {
        $table->id();
        $table->string('key', 50)->unique();
        $table->text('value')->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('settings');
}
};
