<?php

namespace App\Modules\Auth\Application\DTOs;

final readonly class JwtClaims
{
    public function __construct(
        public int $userId,
        public int $expiresAt,
        public string $jti,
    ) {}
}
