<?php

namespace App\Modules\Auth\Domain\Repositories;

use App\Modules\Auth\Domain\Entities\AuthSession;
use DateTimeImmutable;

interface AuthSessionRepository
{
    public function create(
        string $publicId,
        int $userId,
        string $deviceUuid,
        string $refreshTokenHash,
        DateTimeImmutable $expiresAt,
    ): AuthSession;

    public function findActiveByUserAndDevice(int $userId, string $deviceUuid): ?AuthSession;

    public function updateRefreshTokenHash(int $sessionId, string $refreshTokenHash): void;
}
