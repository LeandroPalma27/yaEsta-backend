<?php

namespace App\Modules\Auth\Application\Contracts;

use App\Modules\Auth\Application\DTOs\AccessTokenClaims;

interface TokenService
{
    public function generateAccessToken(int $userId, string $sessionUuid): string;

    public function parseAccessToken(string $token): AccessTokenClaims;
}
