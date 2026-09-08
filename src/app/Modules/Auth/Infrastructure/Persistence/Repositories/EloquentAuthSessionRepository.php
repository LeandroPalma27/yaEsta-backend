<?php

namespace App\Modules\Auth\Infrastructure\Persistence\Repositories;

use App\Modules\Auth\Domain\Entities\AuthSession;
use App\Modules\Auth\Domain\Repositories\AuthSessionRepository;
use App\Modules\Auth\Infrastructure\Persistence\Models\AuthSessionModel;
use DateTimeImmutable;

final class EloquentAuthSessionRepository implements AuthSessionRepository
{
    public function create(
        string $publicId,
        int $userId,
        string $refreshTokenHash,
        DateTimeImmutable $expiresAt,
    ): AuthSession {
        $model = AuthSessionModel::query()->create([
            'public_id' => $publicId,
            'user_id' => $userId,
            'refresh_token_hash' => $refreshTokenHash,
            'expires_at' => $expiresAt,
        ]);

        return new AuthSession(
            id: $model->id,
            publicId: $model->public_id,
            userId: $model->user_id,
            refreshTokenHash: $model->refresh_token_hash,
            expiresAt: $model->expires_at->toDateTimeImmutable(),
            revokedAt: null,
        );
    }
}
