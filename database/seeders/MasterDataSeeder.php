<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ProductSize;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // Kategori aroma umum
        foreach (['Fresh', 'Sweet', 'Woody', 'Floral', 'Spicy', 'Citrus'] as $name) {
            Category::firstOrCreate(['name' => $name]);
        }

        // Ukuran botol. HARGA MASIH CONTOH: tanyakan harga asli ke owner,
        // nanti bisa diubah dari halaman admin "Ukuran & Harga".
        $sizes = [
            ['size_label' => '15ml',  'price' => 30000,  'cost_price' => 20000, 'sort_order' => 1],
            ['size_label' => '30ml',  'price' => 50000,  'cost_price' => 35000, 'sort_order' => 2],
            ['size_label' => '50ml',  'price' => 75000,  'cost_price' => 52000, 'sort_order' => 3],
            ['size_label' => '100ml', 'price' => 130000, 'cost_price' => 95000, 'sort_order' => 4],
        ];
        foreach ($sizes as $size) {
            ProductSize::firstOrCreate(['size_label' => $size['size_label']], $size);
        }

        // Pengaturan toko awal (diubah owner di halaman Pengaturan Toko)
        $defaults = [
            'store_whatsapp' => '081292787003',
            'payment_deadline_hours' => '24',
            'max_pickup_days' => '3',
            'default_low_stock' => '2',
        ];
        foreach ($defaults as $key => $value) {
            if (Setting::where('key', $key)->doesntExist()) {
                Setting::set($key, $value);
                }
                }
                }
    }