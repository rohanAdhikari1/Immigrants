<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('optimize:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return "Cache is cleared";
});

Route::get('site/shutdown/{slug}', function ($slug) {
    if ($slug == 'rohan') {
        return Artisan::call('down --secret="iamrohan" --render="maintenance"');
        return "Site is down";
    } else {
        return response(404);
    }
});

Route::get('site/live', function () {
    return Artisan::call('up');
});

Route::get('queue', function () {
    Artisan::call('queue:work --stop-when-empty');
});

Route::get('migrate', function () {
    Artisan::call('migrate');
    return "Migrated";
});

Route::get('seed', function () {
    Artisan::call('db:seed');
    return "Migrated";
});
