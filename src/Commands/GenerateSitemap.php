<?php

namespace Agenciafmd\Sitemap\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generate the sitemap';

    public function handle()
    {
        dispatch(function () {
            SitemapGenerator::create(config('app.url'))
                ->writeToFile(public_path('sitemap.xml'));
        })->onQueue('low');
    }
}
