<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Paksa skema HTTPS HANYA untuk domain publik (great-yuda.my.id), jangan paksa di domain lokal (.local/localhost)
        $host = request()->getHost();
        $isLocal = in_array($host, ['localhost', '127.0.0.1', 'yuda.local']) || str_ends_with($host, '.local');

        if (!$isLocal && (str_starts_with(config('app.url'), 'https://') || request()->header('x-forwarded-proto') === 'https')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
