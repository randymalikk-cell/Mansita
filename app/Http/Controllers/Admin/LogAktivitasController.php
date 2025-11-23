<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    // Otorisasi: Hanya Admin yang dapat mengakses
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Akses hanya untuk Administrator.');
            }
            return $next($request);
        });
    }

    /**
     * Menampilkan daftar log aktivitas seluruh pengguna.
     */
    public function index()
    {
        $logs = LogAktivitas::with('user')->latest()->paginate(20);
        return view('admin.log_aktivitas.index', compact('logs'));
    }
}