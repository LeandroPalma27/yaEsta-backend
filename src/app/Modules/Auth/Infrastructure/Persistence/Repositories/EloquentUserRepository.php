<?php

namespace App\Modules\Auth\Infrastructure\Persistence\Repositories;

use App\Modules\Auth\Domain\Entities\User;
use App\Modules\Auth\Domain\Repositories\UserRepository;
use App\Modules\Auth\Infrastructure\Persistence\Models\UserModel;
use Override;

final class EloquentUserRepository implements UserRepository
{
    #[Override]
    public function findByEmail(string $email): ?User
    {
        $model = UserModel::query()
            ->where('email', $email)
            ->first();

        if (! $model) {
            return null;
        }

        return new User(
            id: $model->id,
            email: $model->email,
            name: $model->name,
            emailVerifiedAt: $model->email_verified_at
                ? $model->email_verified_at->toDateTimeImmutable()
                : null,
        );
    }
}
