<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
// use PDOException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'auth.admin'    => \App\Http\Middleware\AdminMiddleware::class,
            'auth.cliente'  => \App\Http\Middleware\ClienteMiddleware::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions): void {

        // Solo errores REALES de conexión
        $exceptions->render(function (PDOException $e, Request $request) {

            if (
                str_contains($e->getMessage(), 'Connection refused') ||
                str_contains($e->getMessage(), 'Access denied') ||
                str_contains($e->getMessage(), 'Unknown database') ||
                str_contains($e->getMessage(), 'SQLSTATE[HY000] [2002]')
            ) {
                return response()->view(
                    'errors.db_config',
                    ['message' => $e->getMessage()],
                    500
                );
            }

            return null;
        });

        // Solo errores de consulta ocasionados por conexión
        $exceptions->render(function (QueryException $e, Request $request) {

            $mensaje = $e->getMessage();

            if (
                str_contains($mensaje, 'Connection refused') ||
                str_contains($mensaje, 'Access denied') ||
                str_contains($mensaje, 'Unknown database') ||
                str_contains($mensaje, 'SQLSTATE[HY000] [2002]')
            ) {
                return response()->view(
                    'errors.db_config',
                    ['message' => $mensaje],
                    500
                );
            }

            return null;
        });

        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })

    ->create();