<?php

namespace Agenciafmd\Sitemap\Providers;

use Agenciafmd\Sitemap\Commands\GenerateSitemap;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            GenerateSitemap::class,
        ]);

        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $minutes = config('admix.schedule.minutes');

            $schedule->command('sitemap:generate')
                ->withoutOverlapping()
                ->dailyAt("04:{$minutes}")
                ->appendOutputTo(storage_path('logs/command-sitemap-generate-' . date('Y-m-d') . '.log'));
        });
    }
}
