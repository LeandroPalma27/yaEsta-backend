<?php

return [

    'secret' => env('JWT_SECRET'),

    'algorithm' => env('JWT_ALGORITHM', 'HS256'),

    'ttl' => (int) env('JWT_TTL', 900),

    'issuer' => env('JWT_ISSUER', 'yaesta-api'),

];