<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CheckBlockedUser;

//Starts the Laravel application and sets project root path
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    //Routing setup
    ->withMiddleware(function (Middleware $middleware): void
    {
        $middleware->alias([

            'role' => \App\Http\Middleware\RoleMiddleware::class,

            'admin' => AdminMiddleware::class,

            'blocked' => CheckBlockedUser::class,

        ]);
    })

    ->withExceptions(function (Exceptions $exceptions): void
    {
        //
    })

    ->create();