<?php

namespace App\Modules\Auth\Infrastructure\Persistence\Models;

use Illuminate\Console\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'email',
    'name',
    'password_hash',
])]
#[Hidden([
    'password_hash',
])]
final class AuthAccountModel extends Model
{
    protected $table = 'auth_accounts';

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            UserModel::class,
            'user_id',
            'id',
        );
    }
}
