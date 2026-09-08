<?php

namespace App\Modules\Auth\Domain\Repositories;

use App\Modules\Auth\Domain\Entities\AuthSession;
use DateTimeImmutable;

interface AuthSessionRepository
{
    public function create(
        string $publicId,
        int $userId,
        string $refreshTokenHash,
        DateTimeImmutable $expiresAt,
    ): AuthSession;
}
