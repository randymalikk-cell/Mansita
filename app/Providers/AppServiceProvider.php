<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    // ... properti dan method lainnya

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        // Pendaftaran Alias Middleware Kustom di sini
        $this->aliasMiddleware();

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            // ... (Kode untuk Route API dan Web)
        });
    }

    /**
     * Daftarkan alias middleware kustom.
     */
    protected function aliasMiddleware(): void
    {
        // Mendapatkan instance router
        $router = $this->app['router'];

        // Mendaftarkan alias 'role' ke middleware CheckUserRole
        $router->aliasMiddleware('role', \App\Http\Middleware\CheckUserRole::class);
    }
}