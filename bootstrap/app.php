<?php

use App\Exceptions\CustomException;
use App\Exceptions\CustomNotFoundException;
use App\Http\Middleware\CheckStorePermission;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware(['api'])->prefix("v1/")->group(function () {

                Route::middleware('api')->prefix("admin")->group(base_path("routes/admin.php"));
                Route::middleware('api')->prefix("client")->group(base_path("routes/client.php"));
                Route::middleware('api')->prefix("administrator")->group(base_path("routes/administrator.php"));
            });
        },
    )
    ->withMiddleware(function (Middleware $middleware) {

        // $middleware->append(CheckStorePermission::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (CustomException $e, Request $request) {
            //dd($e.getMessage());
            return response()->json([
                'error' => 'Resource not found',
                "message" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        });

        $exceptions->render(function (CustomNotFoundException $e, Request $request) {
            return response()->json([
                'error' => 'Resource not found',
                'message' => $e->getMessage(),
                'code' => 404,
            ], 404);
        });
    })->create();
