<?php

namespace Agenciafmd\Sitemap\Providers;

use Illuminate\Support\ServiceProvider;

class SitemapServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->providers();
    }

    public function register()
    {
      //
    }

    protected function providers()
    {
        $this->app->register(CommandServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
    }

}
