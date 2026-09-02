<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthSession extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'refresh_token_hash',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
