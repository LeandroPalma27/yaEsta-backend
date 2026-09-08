<?php

namespace App\Modules\Auth\Application\DTOs;

final readonly class AccessTokenClaims
{
    public function __construct(
        public int $userId,
        public int $expiresAt,
        public string $jti,
    ) {}
}
