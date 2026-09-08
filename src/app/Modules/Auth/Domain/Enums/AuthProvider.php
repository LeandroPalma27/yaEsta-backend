<?php

namespace App\Modules\Auth\Domain\Enums;

enum AuthProvider: string
{
    case PASSWORD = 'password';
    case GOOGLE = 'google';
}
