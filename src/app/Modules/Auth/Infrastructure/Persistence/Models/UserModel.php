<?php

namespace App\Modules\Auth\Infrastructure\Persistence\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class UserModel extends Model
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;
    protected $table = 'users';

    protected $fillable = [
        'email',
        'name',
        'email_verified_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function authAccounts(): HasMany
    {
        return $this->hasMany(
            AuthAccountModel::class,
            'user_id',
            'id',
        );
    }
}
