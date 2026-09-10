<?php

use App\Modules\Auth\Application\Exceptions\AccessTokenExpiredException;
use App\Modules\Auth\Application\Exceptions\InvalidAccessTokenException;
use App\Modules\Auth\Application\Exceptions\InvalidCredentialsException;
use App\Modules\Auth\Presentation\Http\Middleware\AuthenticateAccessToken;
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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'auth.jwt' => AuthenticateAccessToken::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn(Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
        
        $exceptions->render(
            function (
                InvalidCredentialsException $e,
                Request $request,
            ) {
                return response()->json([
                    'message' => 'Credenciales inválidas.',
                ], 401);
            }
        );

        $exceptions->render(
            function (
                AccessTokenExpiredException $e,
                Request $request,
            ) {
                return response()->json([
                    'message' => 'El access token ha expirado.',
                    'code' => 'ACCESS_TOKEN_EXPIRED',
                ], 401);
            }
        );

        $exceptions->render(
            function (
                InvalidAccessTokenException $e,
                Request $request,
            ) {
                return response()->json([
                    'message' => 'El access token no es válido.',
                    'code' => 'INVALID_ACCESS_TOKEN',
                ], 401);
            }
        );
    })->create();
