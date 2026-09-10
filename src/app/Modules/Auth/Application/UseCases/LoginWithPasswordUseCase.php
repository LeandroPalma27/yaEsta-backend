<?php

namespace App\Modules\Auth\Application\UseCases;

use App\Modules\Auth\Application\Contracts\LoginWithPassword;
use App\Modules\Auth\Application\Contracts\PasswordHasher;
use App\Modules\Auth\Application\Contracts\TokenService;
use App\Modules\Auth\Application\Exceptions\InvalidCredentialsException;
use App\Modules\Auth\Domain\Enums\AuthProvider;
use App\Modules\Auth\Domain\Repositories\AuthAccountRepository;
use App\Modules\Auth\Domain\Repositories\AuthSessionRepository;
use App\Modules\Auth\Domain\Repositories\UserRepository;
use DateTimeImmutable;
use DateTimeZone;
use Illuminate\Support\Str;

class LoginWithPasswordUseCase implements LoginWithPassword
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private UserRepository $userRepository,
        private AuthAccountRepository $authAccountRepository,
        private AuthSessionRepository  $authSessionRepository,
        private PasswordHasher $hasher,
        private TokenService $tokenService,
    ) {
        //
    }

    public function execute(
        string $email,
        string $password,
        string $deviceUuid,
    ): array {

        $user = $this->userRepository->findByEmail($email);

        if (! $user) {
            throw new InvalidCredentialsException("Credenciales inválidas.");
        }

        $authAccount = $this->authAccountRepository
            ->findByUserIdAndProvider(
                $user->getId(),
                AuthProvider::PASSWORD,
            );

        if (! $authAccount) {
            throw new InvalidCredentialsException("Credenciales inválidas.");
        }

        if (! $this->hasher->verifyPassword(
            $password,
            $authAccount->getPasswordHash()
        )) {
            throw new InvalidCredentialsException("Credenciales inválidas.");
        }

        $session = $this->authSessionRepository
            ->findActiveByUserAndDevice(
                userId: $user->getId(),
                deviceUuid: $deviceUuid,
            );

        if (! $session) {

            $sessionUuid = (string) Str::uuid7();

            $expiresAt = new DateTimeImmutable(
                '+30 days',
                new DateTimeZone('UTC'),
            );

            $refreshSecret = bin2hex(
                random_bytes(32)
            );

            $refreshTokenHash = hash(
                'sha256',
                $refreshSecret,
            );

            $session = $this->authSessionRepository->create(
                publicId: $sessionUuid,
                userId: $user->getId(),
                deviceUuid: $deviceUuid,
                refreshTokenHash: $refreshTokenHash,
                expiresAt: $expiresAt,
            );
        } else {

            $refreshSecret = bin2hex(
                random_bytes(32)
            );

            $refreshTokenHash = hash(
                'sha256',
                $refreshSecret,
            );

            $this->authSessionRepository
                ->updateRefreshTokenHash(
                    sessionId: $session->getId(),
                    refreshTokenHash: $refreshTokenHash,
                );
        }

        $refreshToken = sprintf(
            '%s.%s',
            $session->getPublicId(),
            $refreshSecret,
        );

        $accessToken = $this->tokenService
            ->generateAccessToken(userId: $user->getId(), sessionUuid: $session->getPublicId());

        return [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'token_type' => 'Bearer',
            'expires_in' => (int) config('jwt.ttl'),
        ];
    }
}
