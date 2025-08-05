<?php

use Illuminate\Support\Facades\Route;

Route::get('/test-oauth', function () {
    return [
        'GOOGLE_CLIENT_ID' => env('GOOGLE_CLIENT_ID'),
        'GOOGLE_CLIENT_SECRET' => env('GOOGLE_CLIENT_SECRET') ? '***' : 'Not set',
        'GOOGLE_REDIRECT_URI' => env('GOOGLE_REDIRECT_URI'),
        'config_google' => config('services.google'),
    ];
});
