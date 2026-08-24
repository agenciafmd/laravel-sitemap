<?php

declare(strict_types=1);

namespace Agenciafmd\Sitemap\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;

final class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generate the sitemap';

    public function handle(): void
    {
        dispatch(static function () {
            SitemapGenerator::create(config('app.url'))
                ->shouldCrawl(function ($url) {
                    if ($url === '') {
                        return false;
                    }

                    if (str_contains($url, '?')) {
                        return false;
                    }

                    return true;
                })
                ->getSitemap()
                ->writeToDisk(config('filesystems.default'), 'sitemap.xml', true);
        })->onQueue('low');
    }
}
