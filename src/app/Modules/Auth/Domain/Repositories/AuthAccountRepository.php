<?php

namespace App\Modules\Auth\Domain\Repositories;

use App\Modules\Auth\Domain\Entities\AuthAccount;
use App\Modules\Auth\Domain\Enums\AuthProvider;

interface AuthAccountRepository
{
    public function findByUserIdAndProvider(int $userId, AuthProvider $provider): ?AuthAccount;
}
