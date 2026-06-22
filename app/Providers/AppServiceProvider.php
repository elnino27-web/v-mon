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
        if (env('GOOGLE_JSON_CREDS') && !file_exists(storage_path('app/google/credentials.json'))) {
            if (!is_dir(storage_path('app/google'))) {
                mkdir(storage_path('app/google'), 0755, true);
            }
            file_put_contents(storage_path('app/google/credentials.json'), env('GOOGLE_JSON_CREDS'));
        }
    }
}
