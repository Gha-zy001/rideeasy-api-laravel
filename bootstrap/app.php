<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\Core\ApiVersionMiddleware;
use App\Http\Middleware\Core\CheckTokenExpiry;
use App\Http\Middleware\Core\HstsMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    web: __DIR__ . '/../routes/web.php',
    api: __DIR__ . '/../routes/api.php',
    commands: __DIR__ . '/../routes/console.php',
    health: '/up',
  )
  ->withMiddleware(function (Middleware $middleware): void {
    $middleware->group('api', [
      ApiVersionMiddleware::class,
      HstsMiddleware::class,
      'check.token.expiry' => CheckTokenExpiry::class,

    ]);
  })
  ->withExceptions(function (Exceptions $exceptions): void {
    //
  })->create();
