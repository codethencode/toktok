<?php

use App\Http\Middleware\CheckFormExpiration;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
      // $middleware->append(CheckFormExpiration::class);
        $middleware->validateCsrfTokens(except: [
            'stripe/*',
            'stripe',
            '/stripe/*',
            '/stripe',
            'pay/*',
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->respond(function (Response $response) {
            if ($response->getStatusCode() === 419) {
                return back()->with([
                    'message' => 'The page expired, please try again.',
                ]);
            }


            return $response;
        });
    })->create();
