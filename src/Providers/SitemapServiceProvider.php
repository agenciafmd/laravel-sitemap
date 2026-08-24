<?php

declare(strict_types=1);

namespace Agenciafmd\Sitemap\Providers;

use Illuminate\Support\ServiceProvider;

final class SitemapServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->bootProviders();
    }

    public function register(): void
    {
        //
    }

    private function bootProviders(): void
    {
        $this->app->register(CommandServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
    }
}
