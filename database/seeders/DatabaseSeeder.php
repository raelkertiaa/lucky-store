<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::firstOrNew(['email' => env('ADMIN_EMAIL', 'admin@luckystore.test')]);

        $admin->fill([
            'name' => env('ADMIN_NAME', 'Nexx'),
            'phone' => env('ADMIN_PHONE', '085891316828'),
            'password' => env('ADMIN_PASSWORD', 'tenlucky')
        ]);

        $admin->role = UserRole::Admin;
        $admin->save();
    }
}
