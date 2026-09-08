<?php

namespace App\Modules\Auth\Domain\Entities;

use App\Modules\Auth\Domain\Enums\AuthProvider;

final class AuthAccount
{
    private int $id;
    private int $userId;
    private AuthProvider $provider;
    private ?string $providerAccountId;
    private ?string $passwordHash;

    public function __construct(
        int $id,
        int $userId,
        AuthProvider $provider,
        ?string $providerAccountId = null,
        ?string $passwordHash = null,
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->provider = $provider;
        $this->providerAccountId = $providerAccountId;
        $this->passwordHash = $passwordHash;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getProvider(): AuthProvider
    {
        return $this->provider;
    }

    public function getProviderAccountId(): ?string
    {
        return $this->providerAccountId;
    }

    public function getPasswordHash(): ?string
    {
        return $this->passwordHash;
    }

    public function setPasswordHash(string $passwordHash): void
    {
        $this->passwordHash = $passwordHash;
    }

    public function isPasswordAccount(): bool
    {
        return $this->provider === AuthProvider::PASSWORD;
    }

    public function isGoogleAccount(): bool
    {
        return $this->provider === AuthProvider::GOOGLE;
    }
}
