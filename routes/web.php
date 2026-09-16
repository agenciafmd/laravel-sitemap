<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::permanentRedirect('/sitemap.xml', Storage::url('sitemap.xml'));
