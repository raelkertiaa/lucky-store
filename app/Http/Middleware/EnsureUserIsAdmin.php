<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // ?-> = kalau user null (belum login), hasilnya null, bukan error
        if (! $request->user()?->isAdmin()) {
            abort(403, 'Halaman ini khusus admin.');
        }

        // Lolos pemeriksaan: lanjutkan ke controller
        return $next($request);
    }
}