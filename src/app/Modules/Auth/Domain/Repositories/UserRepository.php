<?php

namespace App\Modules\Auth\Domain\Repositories;

use App\Modules\Auth\Domain\Entities\User;


interface UserRepository
{
    public function findByEmail(string $email): ?User;
}
