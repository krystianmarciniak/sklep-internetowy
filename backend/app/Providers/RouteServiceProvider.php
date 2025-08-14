<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Namespace, który będzie domyślnie dopinany do kontrolerów w trasach.
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Zarejestruj wszelkie profile rate limiting.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            // limit 60 req/min na użytkownika/IP
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    /**
     * Wykonaj bootstrapping tras.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            // wszystkie trasy z routes/api.php pod prefiksem /api
            Route::prefix('api')
                 ->middleware('api')
                 ->namespace($this->namespace)
                 ->group(base_path('routes/api.php'));

            // jeśli kiedyś będziesz potrzebował tras web (Blade, sesje itp.),
            // odkomentuj poniższy blok:
            //
            // Route::middleware('web')
            //      ->namespace($this->namespace)
            //      ->group(base_path('routes/web.php'));
        });
    }
}
