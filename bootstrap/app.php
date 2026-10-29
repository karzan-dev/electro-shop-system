<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RoleMiddleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

// ✅ ڕاستکردنەوەی public_path بۆ Hostinger
// ئەمە دەبێتە هۆی ئەوەی public_path('images/products') بگەڕێتەوە بۆ public_html/images/products
$app->bind('path.public', function () use ($app) {
    return dirname($app->basePath()) . '/public_html';
});

return $app;