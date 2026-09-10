<?php

namespace App\Modules\Auth\Infrastructure\Providers;

use App\Modules\Auth\Application\Contracts\LoginWithPassword;
use App\Modules\Auth\Application\Contracts\PasswordHasher;
use App\Modules\Auth\Application\Contracts\TokenService;
use App\Modules\Auth\Application\UseCases\LoginWithPasswordUseCase;
use App\Modules\Auth\Domain\Repositories\AuthAccountRepository;
use App\Modules\Auth\Domain\Repositories\AuthSessionRepository;
use App\Modules\Auth\Domain\Repositories\UserRepository;
use App\Modules\Auth\Infrastructure\Persistence\Repositories\EloquentAuthAccountRepository;
use App\Modules\Auth\Infrastructure\Persistence\Repositories\EloquentAuthSessionRepository;
use App\Modules\Auth\Infrastructure\Persistence\Repositories\EloquentUserRepository;
use App\Modules\Auth\Infrastructure\Security\FirebaseJwtTokenService;
use App\Modules\Auth\Infrastructure\Security\LaravelPasswordHasher;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            TokenService::class,
            FirebaseJwtTokenService::class,
        );

        $this->app->bind(
            PasswordHasher::class,
            LaravelPasswordHasher::class,
        );

        $this->app->bind(
            UserRepository::class,
            EloquentUserRepository::class,
        );

        $this->app->bind(
            AuthAccountRepository::class,
            EloquentAuthAccountRepository::class,
        );

        $this->app->bind(
            AuthSessionRepository::class,
            EloquentAuthSessionRepository::class,
        );

        $this->app->bind(
            LoginWithPassword::class,
            LoginWithPasswordUseCase::class,
        );
    }
}
