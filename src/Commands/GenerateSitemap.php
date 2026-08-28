<?php

declare(strict_types=1);

namespace Agenciafmd\Sitemap\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

final class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generate the sitemap';

    public function handle(): void
    {
        dispatch(static function () {
            SitemapGenerator::create(config('app.url'))
                ->shouldCrawl(function (string $url) {
                    return $url !== '';
                })
                ->hasCrawled(function (Url $url) {
                    if (str_contains($url->url, '?')) {
                        return false;
                    }

                    return $url;
                })
                ->getSitemap()
                ->sort()
                ->writeToDisk(config('filesystems.default'), 'sitemap.xml', true);
        })->onQueue('low');
    }
}
