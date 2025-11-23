<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  Daftar role yang diizinkan (e.g., 'admin', 'pengurus')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah pengguna sudah login
        if (!Auth::check()) {
            // Jika belum login, redirect ke halaman login
            return redirect('/login'); 
        }

        $user = Auth::user();
        
        // 2. Cek apakah role pengguna ada di daftar role yang diizinkan
        if (!in_array($user->role, $roles)) {
            // Jika role tidak diizinkan, tampilkan error 403 Forbidden
            abort(403, 'Akses Ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}