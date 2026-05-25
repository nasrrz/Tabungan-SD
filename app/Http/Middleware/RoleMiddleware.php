<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login atau belum
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Cek apakah role user saat ini ada di dalam daftar role yang diizinkan
        $user = Auth::user();
        if (in_array($user->role, $roles)) {
            return $next($request); // Lolos, silakan masuk halaman
        }

        // 3. Jika menyelinap ke role lain, lempar error 403 (Forbidden)
        abort(403, 'Anda tidak memiliki hak akses untuk halaman ini!');
    }
}