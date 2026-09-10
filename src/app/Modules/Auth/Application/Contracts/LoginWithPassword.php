<?php

namespace App\Modules\Auth\Application\Contracts;

interface LoginWithPassword
{
    public function execute(
        string $email,
        string $password,
        string $deviceUuid,
    ): array;
}
