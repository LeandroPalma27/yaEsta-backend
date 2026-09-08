<?php

namespace App\Modules\Auth\Infrastructure\Security;

use App\Modules\Auth\Application\Contracts\JwtTokenServiceInterface;
use App\Modules\Auth\Application\Contracts\TokenService;
use App\Modules\Auth\Application\DTOs\AccessTokenClaims;
use App\Modules\Auth\Application\DTOs\JwtClaims;
use App\Modules\Auth\Application\Exceptions\AccessTokenExpiredException;
use App\Modules\Auth\Application\Exceptions\InvalidAccessTokenException;
use DomainException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use LogicException;
use Override;
use UnexpectedValueException;

class FirebaseJwtTokenService implements TokenService
{
    #[Override]
    public function generateAccessToken(int $userId, string $sessionUuid): string
    {
        $now = time();

        $payload = [
            'iss' => $this->issuer(),
            'sub' => (string) $userId,

            'iat' => $now,
            'nbf' => $now,
            'exp' => $now + $this->ttl(),

            'jti' => bin2hex(random_bytes(16)),

            'typ' => 'access',
        ];

        return JWT::encode(
            $payload,
            $this->secret(),
            $this->algorithm(),
        );
    }

    #[Override]
    public function parseAccessToken(string $token): AccessTokenClaims
    {
        $key = new Key(
            $this->secret(),
            $this->algorithm(),
        );

        try {
            $payload = JWT::decode($token, $key);
        } catch (ExpiredException $e) {
            throw new AccessTokenExpiredException(
                'El access token ha expirado.',
                previous: $e,
            );
        } catch (UnexpectedValueException | DomainException $e) {
            throw new InvalidAccessTokenException(
                'El access token no es válido.',
                previous: $e,
            );
        }

        if (
            ! isset($payload->sub, $payload->exp, $payload->jti)
            || ($payload->iss ?? null) !== $this->issuer()
            || ($payload->typ ?? null) !== 'access'
        ) {
            throw new InvalidAccessTokenException(
                'El access token contiene claims inválidos.'
            );
        }

        return new AccessTokenClaims(
            userId: (int) $payload->sub,
            expiresAt: (int) $payload->exp,
            jti: (string) $payload->jti,
        );
    }

    private function secret(): string
    {
        $secret = (string) config('jwt.secret');

        if ($secret === '') {
            throw new LogicException(
                'JWT_SECRET no está configurado.'
            );
        }

        return $secret;
    }

    private function algorithm(): string
    {
        return (string) config('jwt.algorithm');
    }

    private function ttl(): int
    {
        return (int) config('jwt.ttl');
    }

    private function issuer(): string
    {
        return (string) config('jwt.issuer');
    }
}
