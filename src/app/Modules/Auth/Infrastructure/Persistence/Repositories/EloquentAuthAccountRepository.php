<?php

namespace App\Modules\Auth\Infrastructure\Persistence\Repositories;

use App\Modules\Auth\Domain\Entities\AuthAccount;
use App\Modules\Auth\Domain\Enums\AuthProvider;
use App\Modules\Auth\Domain\Repositories\AuthAccountRepository;
use App\Modules\Auth\Infrastructure\Persistence\Models\AuthAccountModel;

final class EloquentAuthAccountRepository implements AuthAccountRepository
{
    public function findByUserIdAndProvider(
        int $userId,
        AuthProvider $provider,
    ): ?AuthAccount {

        $model = AuthAccountModel::query()
            ->where('user_id', $userId)
            ->where('provider', $provider->value)
            ->first();

        if (! $model) {
            return null;
        }

        return new AuthAccount(
            id: $model->id,
            userId: $model->user_id,
            provider: AuthProvider::from($model->provider),
            providerAccountId: $model->provider_account_id,
            passwordHash: $model->password_hash,
        );
    }
}
