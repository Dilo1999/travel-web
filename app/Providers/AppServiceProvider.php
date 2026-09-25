<?php

namespace App\Providers;

use App\Translation\DatabaseLoader;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Serve translations from the translations table (filled by the admin Translator page) over the lang files.
        $this->app->extend('translation.loader', fn ($loader) => new DatabaseLoader($loader));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // MySQL (e.g. MariaDB / older MySQL) has a 1000-byte index limit with utf8mb4.
        // Default string length 191 keeps unique indexes under that limit.
        Schema::defaultStringLength(191);

        // Styles for the language switch on the package edit form (PackageResource).
        Filament::serving(fn () => Filament::registerRenderHook(
            'styles.end',
            fn () => view('filament.content-locale-styles'),
        ));

        // Use current request origin for storage URLs so Filament file previews
        // work without CORS (e.g. when using 127.0.0.1:8000 vs localhost).
        if (! $this->app->runningInConsole() && $this->app->request?->getHost()) {
            $url = $this->app->request->getSchemeAndHttpHost();
            config(['filesystems.disks.public.url' => $url.'/storage']);
        }
    }
}
