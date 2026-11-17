<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    // 1. Rapikan input No. HP sebelum divalidasi: buang spasi, strip, titik.
    //    "0812-3456 7890" → "081234567890"
    $request->merge([
        'phone' => preg_replace('/[\s\-\.]/', '', (string) $request->input('phone')),
    ]);

    // 2. Validasi. Kalau gagal, Laravel otomatis kembali ke form
    //    dan menampilkan pesan error di bawah input yang salah.
    $request->validate([
        'name'     => ['required', 'string', 'max:100'],
        'email'    => ['required', 'string', 'lowercase', 'email', 'max:100', 'unique:' . User::class],
        // Format HP Indonesia: diawali 08 / 628 / +628, total 10–15 digit
        'phone'    => ['required', 'regex:/^(\+62|62|0)8[0-9]{7,12}$/'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ], [
        'phone.regex' => 'Nomor WhatsApp tidak valid. Contoh: 081234567890.',
    ]);

    // 3. Simpan user baru. Role otomatis 'customer' (default di database).
    //    Password tidak perlu di-hash manual: cast 'hashed' di Model User sudah mengurusnya.
    //    No. HP otomatis diubah ke format 628xx oleh mutator di Model User.
    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'phone'    => $request->phone,
        'password' => $request->password,
    ]);

    // 4. Kirim event "user terdaftar" (dipakai Laravel untuk fitur verifikasi email jika diaktifkan)
    event(new Registered($user));

    // 5. Langsung login, lalu arahkan ke beranda
    Auth::login($user);

    return redirect()->route('home');
}
}