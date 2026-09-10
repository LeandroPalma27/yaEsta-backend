<?php

namespace App\Modules\Auth\Presentation\Http\Middleware;

use App\Modules\Auth\Application\Contracts\TokenService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class AuthenticateAccessToken
{
    public function __construct(
        private TokenService $tokenService,
    ) {}

    public function handle(
        Request $request,
        Closure $next,
    ): Response {
        $token = $request->bearerToken();

        if (! $token) {
            return response()->json([
                'message' => 'Access token requerido.',
            ], 401);
        }

        $claims = $this->tokenService
            ->parseAccessToken($token);

        $request->attributes->set(
            'access_token_claims',
            $claims,
        );

        $request->attributes->set(
            'auth_user_id',
            $claims->userId,
        );

        $request->attributes->set(
            'auth_session_uuid',
            $claims->sessionUuid,
        );

        return $next($request);
    }
}
