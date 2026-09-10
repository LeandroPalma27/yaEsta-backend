<?php

namespace App\Modules\Auth\Domain\Entities;

use DateTimeImmutable;

final class AuthSession
{
    private int $id;
    private string $publicId;
    private int $userId;
    private string $refreshTokenHash;
    private string $deviceUuid;
    private DateTimeImmutable $expiresAt;
    private ?DateTimeImmutable $revokedAt;

    public function __construct(
        int $id,
        string $publicId,
        int $userId,
        string $refreshTokenHash,
        string $deviceUuid,
        DateTimeImmutable $expiresAt,
        ?DateTimeImmutable $revokedAt = null,
    ) {
        $this->id = $id;
        $this->publicId = $publicId;
        $this->userId = $userId;
        $this->refreshTokenHash = $refreshTokenHash;
        $this->deviceUuid = $deviceUuid;
        $this->expiresAt = $expiresAt;
        $this->revokedAt = $revokedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPublicId(): string
    {
        return $this->publicId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getRefreshTokenHash(): string
    {
        return $this->refreshTokenHash;
    }

    public function getDeviceUuid(): string
    {
        return $this->deviceUuid;
    }

    public function getExpiresAt(): DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function getRevokedAt(): ?DateTimeImmutable
    {
        return $this->revokedAt;
    }

    public function isRevoked(): bool
    {
        return $this->revokedAt !== null;
    }

    public function isExpired(): bool
    {
        return $this->expiresAt <= new DateTimeImmutable();
    }
}
