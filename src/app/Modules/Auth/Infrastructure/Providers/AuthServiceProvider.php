<?php

namespace App\Modules\Auth\Infrastructure\Providers;

use App\Modules\Auth\Application\Contracts\JwtTokenServiceInterface;
use App\Modules\Auth\Infrastructure\Security\FirebaseJwtTokenService;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            JwtTokenServiceInterface::class,
            FirebaseJwtTokenService::class,
        );
    }
}
