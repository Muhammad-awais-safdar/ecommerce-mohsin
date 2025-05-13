<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// ⚠️ Add proper middleware like 'auth' or environment check in production
Route::middleware(['web'])->group(function () {

    Route::get('/artisan/migrate', function () {
        Artisan::call('migrate', ['--force' => true]);
        return '✅ Migration complete: ' . Artisan::output();
    });

    Route::get('/artisan/storage-link', function () {
        Artisan::call('storage:link');
        return '✅ Storage linked: ' . Artisan::output();
    });

    Route::get('/artisan/optimize', function () {
        Artisan::call('optimize');
        return '✅ Optimized: ' . Artisan::output();
    });

    Route::get('/artisan/optimize-clear', function () {
        Artisan::call('optimize:clear');
        return '✅ Optimization cache cleared: ' . Artisan::output();
    });

    Route::get('/artisan/cache-clear', function () {
        Artisan::call('cache:clear');
        return '✅ Application cache cleared: ' . Artisan::output();
    });

    Route::get('/artisan/config-clear', function () {
        Artisan::call('config:clear');
        return '✅ Config cache cleared: ' . Artisan::output();
    });

    Route::get('/artisan/route-clear', function () {
        Artisan::call('route:clear');
        return '✅ Route cache cleared: ' . Artisan::output();
    });

    Route::get('/artisan/view-clear', function () {
        Artisan::call('view:clear');
        return '✅ View cache cleared: ' . Artisan::output();
    });

    Route::get('/artisan/db-seed', function () {
        Artisan::call('db:seed', ['--force' => true]);
        return '✅ Database seeding complete: ' . Artisan::output();
    });

});
