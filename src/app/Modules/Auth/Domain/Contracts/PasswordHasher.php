<?php

namespace App\Modules\Auth\Domain\Contracts;

interface PasswordHasher
{
    public function hashPassword(string $password): string;
    public function verifyPassword(string $password, string $hash): bool;
}
