<?php

use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\SecuritySessions;
use App\Http\Middleware\Setup;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        api:  __DIR__ . '/../routes/api.php',
        // health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            HandleInertiaRequests::class,
            SecuritySessions::class,
            Setup::class
        ]);

        $middleware->api(append: [
            SecuritySessions::class
        ]);


        $middleware->encryptCookies([
            'redirect_to',
            'logout'
        ]);
        $middleware->statefulApi();

        // $middleware->api([

        // ]);

        // $middleware->alias([
        //     'auth'
        // ]);



        $middleware->redirectGuestsTo(function () {
            return env("JUZR_URL").'/login';
        });



    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
