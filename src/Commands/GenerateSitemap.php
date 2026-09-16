<?php

declare(strict_types=1);

namespace Agenciafmd\Sitemap\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

#[Description('Generate the sitemap')]
#[Signature('sitemap:generate')]
final class GenerateSitemap extends Command
{
    public function handle(): void
    {
        dispatch(static function (): void {
            SitemapGenerator::create(config('app.url'))
                ->shouldCrawl(fn (string $url): bool => $url !== '')
                ->hasCrawled(function (Url $url): false|Url {
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
