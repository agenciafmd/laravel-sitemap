<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Storage;

Route::redirect('/sitemap.xml', Storage::url('sitemap.xml'), 301);
