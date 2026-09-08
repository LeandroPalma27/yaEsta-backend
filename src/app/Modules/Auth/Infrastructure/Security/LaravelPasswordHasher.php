<?php

namespace App\Modules\Auth\Infrastructure\Security;

use App\Modules\Auth\Application\Contracts\PasswordHasher;
use Illuminate\Contracts\Hashing\Hasher;
use Override;

class LaravelPasswordHasher implements PasswordHasher
{
    public function __construct(private Hasher $hasher) {}

    #[Override]
    public function hashPassword(string $password): string
    {
        return $this->hasher->make($password);
    }

    #[Override]
    public function verifyPassword(string $password, string $hash): bool
    {
        return $this->hasher->check($password, $hash);
    }
}
