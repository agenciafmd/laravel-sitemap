<?php

declare(strict_types=1);

namespace Agenciafmd\Sitemap\Providers;

use Agenciafmd\Sitemap\Commands\GenerateSitemap;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

final class CommandServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            GenerateSitemap::class,
        ]);

        $this->app->booted(function (): void {
            $schedule = $this->app->make(Schedule::class);
            $minutes = config('filament-admix.schedule.minutes');

            $schedule->command('sitemap:generate')
                ->withoutOverlapping()
                ->dailyAt("04:{$minutes}")
                ->appendOutputTo(storage_path('logs/command-sitemap-generate-' . date('Y-m-d') . '.log'));
        });
    }
}
