<?php

return [

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'kasir'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

   'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    
    // Tambahkan guard kasir
    'kasir' => [
        'driver' => 'session',
        'provider' => 'kasirs',
    ],
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],
    
    // Tambahkan provider kasir
    'kasirs' => [
        'driver' => 'eloquent',
        'model' => App\Models\Kasir::class,
    ],
],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],

        'kasirs' => [
            'provider' => 'kasirs',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],
    

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

    
];