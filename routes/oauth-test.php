<?php

use Illuminate\Support\Facades\Route;

Route::get('/test-oauth-config', function () {
    $config = config('services.google');
    
    return [
        'config_services_google' => $config,
        'env' => [
            'GOOGLE_CLIENT_ID' => env('GOOGLE_CLIENT_ID') ? '***' . substr(env('GOOGLE_CLIENT_ID'), -4) : 'Not set',
            'GOOGLE_CLIENT_SECRET' => env('GOOGLE_CLIENT_SECRET') ? '***' . substr(env('GOOGLE_CLIENT_SECRET'), -4) : 'Not set',
            'GOOGLE_REDIRECT_URI' => env('GOOGLE_REDIRECT_URI', 'Not set'),
            'APP_ENV' => env('APP_ENV', 'Not set'),
            'APP_DEBUG' => env('APP_DEBUG', 'Not set'),
        ],
        'redirect_url' => route('login.google'),
    ];
});
