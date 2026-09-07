<?php

namespace App\Modules\Auth\Application\Contracts;

use App\Modules\Auth\Application\DTOs\JwtClaims;

interface JwtTokenServiceInterface
{
    public function generateAccessToken(int $userId): string;

    public function parseAccessToken(string $token): JwtClaims;
}
