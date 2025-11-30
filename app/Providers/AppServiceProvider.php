<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <--- JANGAN LUPA IMPORT INI

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Kode ini WAJIB untuk Vercel agar CSS ter-load
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
