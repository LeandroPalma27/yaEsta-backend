<?php

namespace App\Modules\Auth\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class AuthSessionModel extends Model
{
    protected $table = 'auth_sessions';

    protected $fillable = [
        'public_id',
        'user_id',
        'refresh_token_hash',
        'device_uuid',
        'expires_at',
        'revoked_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'revoked_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    protected $hidden = [
        'refresh_token_hash',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            UserModel::class,
            'user_id',
            'id',
        );
    }
}
