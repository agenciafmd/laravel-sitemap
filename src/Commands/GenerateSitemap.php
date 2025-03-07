<?php

namespace Agenciafmd\Sitemap\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generate the sitemap';

    public function handle(): void
    {
        dispatch(static function () {
            SitemapGenerator::create(config('app.url'))
                ->shouldCrawl(function ($url) {
                    if ($url->getPath() === '') {
                        return false;
                    }

                    if ($url->getQuery()) {
                        return false;
                    }

                    return true;
                })
                ->getSitemap()
                ->writeToDisk(config('filesystems.default'), 'sitemap.xml');
        })->onQueue('low');
    }
}
