<?php

use App\Exceptions\CustomException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (CustomException $e, Request $request) {
            //dd($e.getMessage());
            return response()->json(["message" => $e->getMessage(), 500]);
        });
    })->create();