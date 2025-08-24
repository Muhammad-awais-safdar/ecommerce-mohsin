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



    Route::get('/artisan/migrate-fresh-seed', function () {
        // Run migrate:fresh first
        Artisan::call('migrate:fresh', ['--force' => true]);

        // Then seed the database
        Artisan::call('db:seed', ['--force' => true]);

        return '✅ Database migrated fresh and seeding complete: <br>' . nl2br(Artisan::output());
    });
    Route::get('/artisan/reset-all', function () {
        $output = [];

        // 1. Migrate Fresh
        Artisan::call('migrate:fresh', ['--force' => true]);
        $output[] = "🗑️ Database dropped and migrated fresh.";
        $output[] = Artisan::output();

        // 2. Seed Database
        Artisan::call('db:seed', ['--force' => true]);
        $output[] = "🌱 Database seeding complete.";
        $output[] = Artisan::output();

        // 3. Remove old storage link
        if (file_exists(public_path('storage'))) {
            Artisan::call('storage:unlink');
            $output[] = "🧹 Old storage link removed.";
        }

        // 4. Create new storage link
        Artisan::call('storage:link');
        $output[] = "🔗 New storage link created.";
        $output[] = Artisan::output();

        // 5. Optimize Clear
        Artisan::call('optimize:clear');
        $output[] = "🧽 Cache cleared.";
        $output[] = Artisan::output();

        // 6. Optimize
        // Artisan::call('optimize');
        // $output[] = "⚡ Optimized.";
        // $output[] = Artisan::output();

        // Return styled HTML
        return response()->make("
        <div style='
            font-family: Arial, sans-serif;
            background:#111;
            color:#eee;
            padding:20px;
            line-height:1.6;
        '>
            <h2 style='color:#4ade80;'>✅ Laravel Reset Completed</h2>
            <ul style='list-style:none;padding:0;'>
                <li>🗑️ Database migrated fresh</li>
                <li>🌱 Database seeded</li>
                <li>🧹 Old storage link removed</li>
                <li>🔗 New storage link created</li>
                <li>🧽 Cache cleared</li>
                <li>⚡ Optimized</li>
            </ul>
            <pre style='background:#222;padding:15px;border-radius:8px;overflow:auto;'>" .
            implode("\n\n", $output) .
            "</pre>
        </div>
    ");
    });
});
