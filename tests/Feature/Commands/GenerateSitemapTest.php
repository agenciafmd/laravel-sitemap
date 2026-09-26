<?php

declare(strict_types=1);

namespace Agenciafmd\Sitemap\Tests\Feature\Commands;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Queue\CallQueuedClosure;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

use function Pest\Laravel\artisan;

uses(TestCase::class, RefreshDatabase::class);

it('queues the sitemap generation on the low queue', function (): void {
    Queue::fake([CallQueuedClosure::class]);

    artisan('sitemap:generate')->assertSuccessful();

    Queue::assertPushedOn('low', CallQueuedClosure::class);
});
