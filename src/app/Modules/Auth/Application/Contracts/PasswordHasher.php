<?php

namespace App\Modules\Auth\Application\Contracts;

interface PasswordHasher
{
    public function hashPassword(string $password): string;
    public function verifyPassword(string $password, string $hash): bool;
}
