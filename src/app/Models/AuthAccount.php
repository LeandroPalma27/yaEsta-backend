<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthAccount extends Model
{
    protected $fillable = [
        'user_id',
        'provider',
        'provider_account_id',
        'password_hash',
    ];

    protected $hidden = [
        'password_hash',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
