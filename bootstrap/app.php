<?php

use App\Http\Middleware\Allowance;
use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\InitializeVisitor;
use App\Http\Middleware\OnFinish;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->encryptCookies(except: ['appearance', 'sidebar_state']);
        $middleware->trustProxies(at: '**');

        $middleware->web(append: [
            InitializeVisitor::class,
            Allowance::class,
            OnFinish::class,
            HandleAppearance::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
