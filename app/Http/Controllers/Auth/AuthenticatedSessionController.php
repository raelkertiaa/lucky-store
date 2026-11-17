<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
   public function store(LoginRequest $request): RedirectResponse
{
    // Cek email + password (logikanya ada di app/Http/Requests/Auth/LoginRequest.php,
    // termasuk pembatasan 5x salah password agar tidak bisa ditebak terus-menerus)
    $request->authenticate();

    // Buat ulang ID sesi setelah login (mencegah serangan "session fixation")
    $request->session()->regenerate();

    // Arahkan sesuai role.
    // intended() = kembali ke halaman yang tadi ingin dibuka sebelum diminta login,
    // kalau tidak ada, pakai halaman default di dalam kurung.
    if ($request->user()->isAdmin()) {
        return redirect()->intended(route('admin.dashboard'));
    }

    return redirect()->intended(route('home'));
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
