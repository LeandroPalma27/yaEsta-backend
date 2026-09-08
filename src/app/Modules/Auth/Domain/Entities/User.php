<?php

namespace App\Modules\Auth\Domain\Entities;

use DateTimeImmutable;

final class User
{
    private int $id;
    private string $email;
    private string $name;
    private ?DateTimeImmutable $emailVerifiedAt;

    public function __construct(
        int $id,
        string $email,
        string $name,
        ?DateTimeImmutable $emailVerifiedAt = null,
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->name = $name;
        $this->emailVerifiedAt = $emailVerifiedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmailVerifiedAt(): ?DateTimeImmutable
    {
        return $this->emailVerifiedAt;
    }

    public function setEmailVerifiedAt(
        ?DateTimeImmutable $emailVerifiedAt
    ): void {
        $this->emailVerifiedAt = $emailVerifiedAt;
    }

    public function isEmailVerified(): bool
    {
        return $this->emailVerifiedAt !== null;
    }
}
