<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\URL;
use App\Models\Author;
use App\Models\Artikel;
use App\Models\Product;
use App\Models\Katalog;
use App\Observers\AuthorObserver;
use App\Observers\ArtikelObserver;
use App\Observers\ProductObserver;
use App\Observers\KatalogObserver;

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
        // Force HTTPS in production or when FORCE_HTTPS is true
        if (config('app.env') === 'production' || config('app.force_https', false)) {
            URL::forceScheme('https');
        }

        // Register model observers for automatic sync to Next.js API
        Author::observe(AuthorObserver::class);
        Artikel::observe(ArtikelObserver::class);
        Product::observe(ProductObserver::class);
        Katalog::observe(KatalogObserver::class);
        
        // Configure API rate limiters
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('search', function (Request $request) {
            return Limit::perMinute(30)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('health', function (Request $request) {
            return Limit::perMinute(120)->by($request->user()?->id ?: $request->ip());
        });
    }
}
