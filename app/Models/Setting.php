<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Ambil satu pengaturan. Hasil disimpan di cache supaya tidak query database terus.
     * Pemakaian: Setting::get('bank_account')
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $all = Cache::rememberForever('settings', fn () => static::pluck('value', 'key')->all());

        return $all[$key] ?? $default;
    }

    /**
     * Simpan satu pengaturan, lalu hapus cache supaya nilai baru langsung terbaca.
     * Pemakaian: Setting::set('bank_account', '1234567890')
     */
    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('settings');
    }
}