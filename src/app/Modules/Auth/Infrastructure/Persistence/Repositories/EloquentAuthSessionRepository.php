<?php

namespace App\Modules\Auth\Infrastructure\Persistence\Repositories;

use App\Modules\Auth\Domain\Entities\AuthSession;
use App\Modules\Auth\Domain\Repositories\AuthSessionRepository;
use App\Modules\Auth\Infrastructure\Persistence\Models\AuthSessionModel;
use DateTimeImmutable;
use Override;

final class EloquentAuthSessionRepository implements AuthSessionRepository
{
    #[Override]
    public function create(
        string $publicId,
        int $userId,
        string $deviceUuid,
        string $refreshTokenHash,
        DateTimeImmutable $expiresAt,
    ): AuthSession {
        $model = AuthSessionModel::query()->create([
            'public_id' => $publicId,
            'user_id' => $userId,
            'refresh_token_hash' => $refreshTokenHash,
            'device_uuid' => $deviceUuid,
            'expires_at' => $expiresAt,
            'revoked_at' => null,
        ]);

        return $this->toDomain($model);
    }

    #[Override]
    public function findActiveByUserAndDevice(int $userId, string $deviceUuid): ?AuthSession
    {
        $model = AuthSessionModel::query()
            ->where('user_id', $userId)
            ->where('device_uuid', $deviceUuid)
            ->whereNull('revoked_at')
            ->where('expires_at', '>', now())
            ->first();

        if (! $model) {
            return null;
        }

        return $this->toDomain($model);
    }

    #[Override]
    public function updateRefreshTokenHash(int $sessionId, string $refreshTokenHash): void
    {
        AuthSessionModel::query()
            ->whereKey($sessionId)
            ->update([
                'refresh_token_hash' => $refreshTokenHash,
            ]);
    }

    private function toDomain(
        AuthSessionModel $model,
    ): AuthSession {
        return new AuthSession(
            id: $model->id,
            publicId: $model->public_id,
            userId: $model->user_id,
            deviceUuid: $model->device_uuid,
            refreshTokenHash: $model->refresh_token_hash,
            expiresAt: $model->expires_at->toDateTimeImmutable(),
            revokedAt: $model->revoked_at
                ? $model->revoked_at->toDateTimeImmutable()
                : null,
        );
    }
}
