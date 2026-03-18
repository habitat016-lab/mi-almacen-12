<?php

return [
    /*
    
|--------------------------------------------------------------------------
    | Authentication Defaults
    
|--------------------------------------------------------------------------
    */
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    
|--------------------------------------------------------------------------
    | Authentication Guards
    
|--------------------------------------------------------------------------
    */
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'credenciales',
        ],

        'filament' => [
            'driver' => 'session',
            'provider' => 'filament_users',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ],
    ],

    /*
    
|--------------------------------------------------------------------------
    | User Providers
    
|--------------------------------------------------------------------------
    */
    'providers' => [
        'credenciales' => [
            'driver' => 'eloquent',
            'model' => App\Models\AsignacionCredencial::class,
        ],

        'filament_users' => [
            'driver' => 'eloquent',
            'model' => App\Models\AuthUser::class,
        ],

        // 'users' => [
        //     'driver' => 'eloquent',
        //     'model' => App\Models\User::class,
        // ],
    ],

    /*
    
|--------------------------------------------------------------------------
    | Resetting Passwords
    
|--------------------------------------------------------------------------
    */
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    
|--------------------------------------------------------------------------
    | Password Confirmation Timeout
    
|--------------------------------------------------------------------------
    */
    'password_timeout' => 10800,
];
